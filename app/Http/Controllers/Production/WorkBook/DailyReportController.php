<?php

namespace App\Http\Controllers\Production\WorkBook;
use App\Models\Folio;
use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\LocationTurn;
use App\Models\LocationProjectUser;
use App\Http\Requests\Production\WorkBook\StoreDailyReportRequest;
use App\Http\Requests\Production\WorkBook\UpdateDailyReportRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class DailyReportController extends Controller
{
    public function index($id) {
        $folio = Folio::with('location')
                ->where('id',$id)
                ->first();
        $turns = LocationTurn::select(DB::raw("'location_turns.id' as id, CONCAT(turns.name, ' [', turns.start, '-', turns.finish, ']') as name"))
                ->join('turns','location_turns.turn_id','=','turns.id')
                ->where('location_id',$folio->location_id)
                ->get();
        $dailyReports = DailyReport::with('turn')
                ->where('folio_id',$folio->id)
                ->get();
        $responsibles = LocationProjectUser::where('location_id',$folio->location_id)
                ->where('dailyreport_approver',1)
                ->get();
        return Inertia::render('Production/WorkBook/DailyReports/Index', [
            'folio' => $folio,
            'dailyReports' => $dailyReports,
            'turns' => $turns,
            'projectUserId' => session('currentProjectUserId'),
            'responsibles' => $responsibles,
        ]);
    }

    public function store(StoreDailyReportRequest $request)
    {
        try{
            $folio=Folio::find($request->folio_id);
            if (is_valid_date_for_create_dailyreport($folio->date, $folio->location)){
                $dailyReport = DailyReport::create($request ->validated());
                return redirect()->back();
            }else{
                return back()->withErrors(__('messages.timeexpiredtocreate').' '.__('content.dailyreport'));
            }
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }
}
