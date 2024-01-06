<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Models\Clock;
use App\Models\Event;
use App\Models\Stakeholder;
use App\Models\StakeholderPersonShift;
use DateTime;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index() {
        $stakeholders = Stakeholder::select('stakeholders.*')
            ->where('project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        $clocks = Clock::with('project')
            ->where('project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        return Inertia::render('People/TimeSheet/Reports/Index', [
            'clocks' => $clocks,
            'stakeholders' => $stakeholders
        ]);
    }

    public function getTimesheet(Request $request)
    {
        if($request->ajax())
        {
            $timesheet = [];

            foreach($request->employees as $employee) {
                $startDate = strtotime($request->since);
                $finishDate = strtotime($request->until);
                
                for($i = $startDate; $i <= $finishDate; $i+=86400){
                    $day = date('Y-m-d', $i);
                    
                    $stakeholderPersonShift = StakeholderPersonShift::select('stakeholder_person_shifts.*')
                        ->with('stakeholderPerson')
                        ->with('shift')
                        ->where('stakeholder_person_id', $employee['value']['id'])
                        ->whereDate('date','=', $day)
                        ->first();
                    if (!empty($stakeholderPersonShift)) {
                        
                        $startTime = strtotime($stakeholderPersonShift->shift->start);
                        $finishTime = strtotime($stakeholderPersonShift->shift->finish);
                        $nextDay = $stakeholderPersonShift->shift->nextday;
                        $breaktime = strtotime($stakeholderPersonShift->shift->breaktime);
                        $earlyCheckin = strtotime($stakeholderPersonShift->shift->earlyCheckin);
                        $lateCheckout = strtotime($stakeholderPersonShift->shift->lateCheckout);
                        $overtime = $stakeholderPersonShift->shift->overtime;
                        
                        $realStartHour = $startTime - $earlyCheckin;
                    
                        $realFinishHour = $finishTime + $lateCheckout;
                        if (!$nextDay) {
                            $initialLimit = new DateTime($day.' '.date('H:i:s',$realStartHour));
                            if (!$overtime) {
                                $finalLimit = new DateTime($day.' '.date('H:i:s',$realFinishHour));
                            } else {
                                $finalLimit = new DateTime($day.' 23:59:59');
                            }
                            
                        } else {
                            $initialLimit = new DateTime($day.' '.date('H:i:s',$realStartHour));
                            $tomorrow = $day + 1;
                            if (!$overtime) {
                                $finalLimit = new DateTime($tomorrow.' '.date('H:i:s',$realFinishHour));
                            } else {
                                $finalLimit = new DateTime($tomorrow.' '.date('H:i:s',$realStartHour));
                            }
                        }

                        $events = Event::select('events.*')
                            ->with('stakeholderPerson.person')
                            ->with('clock')
                            ->whereDate('events.record','>=',$initialLimit)
                            ->whereDate('events.record','<=',$finalLimit)
                            ->where('events.stakeholder_person_id',$employee)
                            ->get();
                        
                        if (!empty($events)) {
                            $dailyEvents = [];
                            
                            foreach ($events as $event){
                                $date = strtotime($event->record);
                                $dailyEvent = date('Y-m-d H:i:s', $date);
                                
                                array_push($dailyEvents, $dailyEvent);
                            }
                            if (!empty($dailyEvents)) {
                            
                                asort($dailyEvents);
                                
                                $lastIndex = count($dailyEvents) - 1;
                                $checkIn = strtotime($dailyEvents[0]);
                                $checkOut = strtotime($dailyEvents[$lastIndex]);
                                
                                $hours = abs($checkIn - $checkOut);
                                
                                if ($hours > $breaktime) {
                                    $hours = abs($hours - $breaktime);
                                }

                                $recordTimesheet = [
                                    'id' => $stakeholderPersonShift->stakeholderPerson->id,
                                    'fullName' => $stakeholderPersonShift->stakeholderPerson->person->fullName,
                                    'day' => $day,
                                    'checkIn' => date('H:i:s', $checkIn),
                                    'checkOut' => date('H:i:s', $checkOut),
                                    'workday' => date('H:i:s',$hours)
                                ];
                                
                                array_push($timesheet, $recordTimesheet);
                            }
                        }
                    }
                }
            }
            return response()->json($timesheet);
        }
    }
}
