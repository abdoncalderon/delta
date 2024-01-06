<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\EquipmentDailyReport;
use App\Http\Requests\Production\Workbook\StoreEquipmentDailyReportRequest;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Exception;

class EquipmentDailyReportController extends Controller
{
    public function store(StoreEquipmentDailyReportRequest $request){
        try{
            EquipmentDailyReport::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(EquipmentDailyReport $equipmentDailyReport)
    {
        try{
            $equipmentDailyReport->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
        
    }

    public function clone(Request $request){
        try {
            $oldDailyReport = DailyReport::find($request->old_daily_report_id);
            foreach($oldDailyReport->equipments as $equipmentDailyReport){
                EquipmentDailyReport::create([
                    'daily_report_id'=>$request->daily_report_id,
                    'stakeholder_id'=>$equipmentDailyReport->stakeholder_id,
                    'equipment_id'=>$equipmentDailyReport->equipment_id,
                    'quantity'=>$equipmentDailyReport->quantity,
                ]);
            }
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
        
    }

    public function getEquipmentsDailyReport(Request $request, $id) {
        if($request->ajax())
        {
            $equipmentsDailyReport = EquipmentDailyReport::select('equipment_daily_reports.*')
                ->with('equipment')
                ->with('stakeholder')
                ->where('daily_report_id',$id)->get();
            return response()->json($equipmentsDailyReport);
        }
    } 
}
