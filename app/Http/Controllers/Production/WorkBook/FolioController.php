<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;

use App\Models\Folio;
use App\Models\Location;
use App\Models\LocationProjectUser;
use App\Http\Requests\Production\Workbook\StoreFolioRequest;
use App\Http\Requests\Production\Workbook\UpdateFolioRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class FolioController extends Controller
{
    public function index() {
        $locations = LocationProjectUser::select('locations.id as id','locations.name as name')
                    ->join('locations','location_project_users.location_id','=','locations.id')
                    ->where('project_user_id',session('current_project_user')->id)
                    ->get();
        
        return Inertia::render('Production/WorkBook/Folios/Index', [
            'locations' => $locations,
            'projectUserId' => session('current_project_user')->id
        ]);
    }

    public function store(StoreFolioRequest $request)
    {
        try{
            $location=Location::find($request->location_id);
            if (is_valid_date_for_project($request->date, $location->zone->project)){
                if (is_valid_date_for_location($request->date, $location)){
                    if (is_valid_date_for_open_folio($request->date, $location)){
                        Folio::create($request->validated());
                        $location->uploadSequence();
                        return redirect()->back();
                    }else{
                        return back()->withErrors(__('messages.timeExpiredToOpenFolio'));
                    }
                }else{
                    return back()->withErrors(__('messages.dateOutsideLocationExecution'));
                }
            }else{
                return back()->withErrors(__('messages.dateOutsideProjectExecution'));
            }
            
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
        
    }

    public function getFoliosXLocation(Request $request, $location_id, $fromDate, $untilDate) 
    {
        if($request->ajax())
        {
            
            $folios = Folio::with('location')
                    ->where('location_id', $location_id)
                    ->whereDate('date','>=', $fromDate)
                    ->whereDate('date','<=', $untilDate)
                    ->orderBy('date')
                    ->get();
            return response()->json($folios);
        }
    }

    public function getFolioNumber(Request $request, $id)
    {
        if($request->ajax())
        {
            $location = Location::find($id);
            return response()->json($location);
        }
    }
}
