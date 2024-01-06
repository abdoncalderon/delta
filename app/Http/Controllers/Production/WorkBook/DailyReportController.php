<?php

namespace App\Http\Controllers\Production\WorkBook;
use App\Models\Folio;
use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\LocationTurn;
use App\Models\LocationProjectUser;
use App\Http\Requests\Production\WorkBook\StoreDailyReportRequest;
use App\Http\Requests\Production\WorkBook\UpdateDailyReportRequest;
use App\Models\Equipment;
use App\Models\Position;
use App\Models\Stakeholder;
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
        $turns = LocationTurn::select(DB::raw("turns.id as id, CONCAT(turns.name, ' [', turns.start, '-', turns.finish, ']') as name"))
                ->join('turns','location_turns.turn_id','=','turns.id')
                ->where('location_id',$folio->location_id)
                ->get();
        $dailyReports = DailyReport::select('daily_reports.*','locations.name as location','locations.id as location_id')
                ->with('turn')
                ->join('folios','daily_reports.folio_id','=','folios.id')
                ->join('locations','folios.location_id','=','locations.id')
                ->where('folio_id',$folio->id)
                ->orderBy('date')
                ->get();
        $responsibles = LocationProjectUser::select('project_users.id as id','people.fullName as name')
                ->join('project_users','location_project_users.project_user_id','=','project_users.id')
                ->join('users','project_users.user_id','=','users.id')
                ->join('people','users.person_id','=','people.id')
                ->where('location_id',$folio->location_id)
                ->where('profile',2)
                ->get();
        $stakeholders = Stakeholder::where('project_id',session('current_project_id'))->get();
        $equipments = Equipment::where('project_id',session('current_project_id'))->get();
        $positions = Position::select('positions.*')
                ->join('funct1ons','positions.function_id','=','funct1ons.id')
                ->where('funct1ons.project_id',session('current_project_id'))
                ->get();
        
        return Inertia::render('Production/WorkBook/DailyReports/Index', [
            'folio' => $folio,
            'dailyReports' => $dailyReports,
            'turns' => $turns,
            'projectUserId' => session('current_project_user')->id,
            'responsibles' => $responsibles,
            'positions' => $positions,
            'equipments' => $equipments,
            'stakeholders' => $stakeholders,
        ]);
    }

    public function store(StoreDailyReportRequest $request)
    {
        try{
            $folio=Folio::find($request->folio_id);
            if (is_valid_date_for_create_dailyreport($folio->date, $folio->location)){
                DailyReport::create($request->validated());
                return redirect()->back();
            }else{
                return back()->withErrors(__('messages.timeexpiredtocreate').' '.__('content.dailyreport'));
            }
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateDailyReportRequest $request, DailyReport $dailyReport)
    {
        try{
            $dailyReport->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(DailyReport $dailyReport){
        try{
            $dailyReport->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getOldDailyReports(Request $request, $location_id, $dailyReport_id) {
        if($request->ajax())
        {
            $oldDailyReports = DailyReport::select(DB::raw("turns.id as id, CONCAT(locations.name,' - ',folios.date,' - ',turns.name) as name"))
                ->join('folios','daily_reports.folio_id','=','folios.id')
                ->join('locations','folios.location_id','=','locations.id')
                ->join('turns','daily_reports.turn_id','=','turns.id')
                ->where('folios.location_id', $location_id)
                ->where('daily_reports.id','!=', $dailyReport_id)
                ->orderBy('date','desc')
                ->get();
            return response()->json($oldDailyReports);
        }
    } 

    
}