<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Models\Clock;
use App\Models\Event;
use App\Models\Stakeholder;
use App\Models\StakeholderPersonShift;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Rats\Zkteco\Lib\ZKTeco;
use RecordTimeSheet;

use function PHPUnit\Framework\isNull;



class AttendanceController extends Controller
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
        return Inertia::render('People/TimeSheet/Attendance/Index', [
            'clocks' => $clocks,
            'stakeholders' => $stakeholders
        ]);
    }

    public function download(Request $request) {
        try {
            foreach ($request->clocks as $clock) {
                if ($clock['checked']){
                    $zkClock = new ZKTeco($clock['value']['ipAddress'], $clock['value']['port']);
                    if ($zkClock->connect()) {
                        $zkClock->disableDevice();
                        $attendance = $zkClock->getAttendance();
                        $zkClock->enableDevice();
                        foreach($attendance as $event) {
                            /* $date = date('Y-m-d', $event['timestamp']);
                            $time = date('H:i:s', $event['timestamp']); */
                            $exist = Event::select('events.*')
                                ->where('uid',$event['uid'])
                                ->first();
                            if (empty($exist)) {
                                Event::create([
                                    'uid' => $event['uid'],
                                    'stakeholder_person_id' => $event['id'],
                                    'state' => $event['state'],
                                    'record' => $event['timestamp'],
                                    /* 'date' => $date,
                                    'time' => $time, */
                                    'type' => $event['type'],
                                    'clock_id' => $clock['value']['id']
                                ]);
                            }
                            
                        }
                    } 

                }
            }
            return redirect()->back();
        } catch(Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function getEvents(Request $request)
    {
        if($request->ajax())
        {
            $events = [];
            foreach($request->employees as $employee) {
                if ($employee['checked']) {
                    $employeeEvents = Event::select('events.*')
                        ->with('stakeholderPerson.person')
                        ->with('clock')
                        ->whereDate('events.record','>=',$request->since)
                        ->whereDate('events.record','<=',$request->until)
                        ->where('events.stakeholder_person_id',$employee['value']['id'])
                        ->get(); 
                    if (!empty($employeeEvents)) {
                        foreach($employeeEvents as $e) {
                            array_push($events, $e);
                        }
                    }
                }
            }
            return response()->json($events);
        }
    }

    


    

    

}