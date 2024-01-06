<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\AttachmentDailyReport;
use App\Http\Requests\Production\Workbook\StoreAttachmentDailyReportRequest;
use Illuminate\Http\Request;
use Exception;

class AttachmentDailyReportController extends Controller
{
    public function store(StoreAttachmentDailyReportRequest $request){
        try{
            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/production/dailyReports/',$fileName);
                AttachmentDailyReport::create([
                    'daily_report_id'=>$request->daily_report_id,
                    'filename'=>$fileName,
                    'description'=>$request->description,
                    'project_user_id'=>$request->project_user_id,
                ]);
                return redirect()->back();
            } else {
                return back()->withErrors('error');
            }
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(AttachmentDailyReport $attachmentDailyReport)
    {
        try{
            $attachmentDailyReport->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
        
    }

    public function getAttachmentsDailyReport(Request $request, $id) {
        if($request->ajax())
        {
            $attachmentsDailyReport = AttachmentDailyReport::select('attachment_daily_reports.*')
                ->where('daily_report_id',$id)->get();
            return response()->json($attachmentsDailyReport);
        }
    }
}
