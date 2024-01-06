<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\EventDailyReport;
use App\Http\Requests\Production\Workbook\StoreEventDailyReportRequest;
use Illuminate\Http\Request;
use Exception;

class EventDailyReportController extends Controller
{
    public function store(StoreEventDailyReportRequest $request){
        try{
            EventDailyReport::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(EventDailyReport $eventDailyReport)
    {
        try{
            $eventDailyReport->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
        
    }

    public function getEventsDailyReport(Request $request, $id) {
        if($request->ajax())
        {
            $eventsDailyReport = EventDailyReport::select('event_daily_reports.*')
                ->where('daily_report_id',$id)->get();
            return response()->json($eventsDailyReport);
        }
    } 
}
