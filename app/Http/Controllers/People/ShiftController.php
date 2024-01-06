<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StoreShiftRequest;
use App\Http\Requests\People\StoreStakeholderPersonShiftRequest;
use App\Http\Requests\People\UpdateShiftRequest;
use App\Models\Project;
use App\Models\Shift;
use App\Imports\ShiftsImport;
use App\Models\Stakeholder;
use App\Models\StakeholderPersonShift;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class ShiftController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $stakeholders = Stakeholder::select('stakeholders.*')
            ->where('project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();
        $shifts = Shift::with('project')
                ->where('project_id',session('current_project_id'))
                ->orderBy('name')
                ->get();
        return Inertia::render('People/TimeSheet/Shifts/Index', [
            'projects' => $projects,
            'shifts' => $shifts,
            'stakeholders' => $stakeholders,
        ]);
    }

    public function store(StoreShiftRequest $request) {
        try{
            Shift::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateShiftRequest $request, Shift $shift) {
        try{
            $shift->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Shift $shift){
        try{
            $shift->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try{
            if($request->hasFile('file')){
                $file = $request->file('file');
                $import = new ShiftsImport;
                $import->import($file);
                if($import->failures()->isNotEmpty()){
                    return redirect()->back()->withErrors($import->failures());
                }else{
                    return redirect()->back();
                }
            }
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function assign(StoreStakeholderPersonShiftRequest $request) {
        try {

            foreach ($request->employees as $employee) {
                if ($employee['checked']){
                    $startDate = strtotime($request->since);
                    $finishDate = strtotime($request->until);
                    for($i = $startDate; $i <= $finishDate; $i+=86400){
                        $day = date('Y-m-d', $i);
                        $exist = StakeholderPersonShift::select('stakeholder_person_shifts.*')
                            ->where('stakeholder_person_id',$employee['value']['id'])
                            ->whereDate('date','=',$day)
                            ->first();
                        if (empty($exist)) {
                            StakeholderPersonShift::create([
                                'stakeholder_person_id' => $employee['value']['id'],
                                'shift_id' => $request->shift_id,
                                'date' => $day,
                            ]);
                        } else {
                            $exist->update([
                                'stakeholder_person_id' => $employee['value']['id'],
                                'shift_id' => $request->shift_id,
                                'date' => $day,
                            ]);
                        }
                        
                    }
                }
            }
            return redirect()->back();
        } catch(Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
