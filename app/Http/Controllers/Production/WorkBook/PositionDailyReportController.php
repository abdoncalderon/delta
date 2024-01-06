<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\PositionDailyReport;
use App\Http\Requests\Production\Workbook\StorePositionDailyReportRequest;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Exception;

class PositionDailyReportController extends Controller
{
    public function store(StorePositionDailyReportRequest $request){
        try{
            PositionDailyReport::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(PositionDailyReport $positionDailyReport)
    {
        try{
            $positionDailyReport->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function clone(Request $request){
        try {
            $oldDailyReport = DailyReport::find($request->old_daily_report_id);
            foreach($oldDailyReport->positions as $positionDailyReport){
                PositionDailyReport::create([
                    'daily_report_id'=>$request->daily_report_id,
                    'stakeholder_id'=>$positionDailyReport->stakeholder_id,
                    'position_id'=>$positionDailyReport->position_id,
                    'quantity'=>$positionDailyReport->quantity,
                ]);
            }
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
        
    }


    public function getPositionsDailyReport(Request $request, $id) {
        if($request->ajax())
        {
            $positionsDailyReport = PositionDailyReport::select('position_daily_reports.*')
                ->with('position')
                ->with('stakeholder')
                ->where('daily_report_id',$id)->get();
            return response()->json($positionsDailyReport);
        }
    } 
}
