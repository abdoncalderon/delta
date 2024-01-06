<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Location;
use App\Models\Turn;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class LocationController extends Controller
{
    public function index()
    {
        $zones = Zone::where('project_id',session('current_project_id'))->get();
        $turns = Turn::where('project_id',session('current_project_id'))->get();

        $locations = Location::select('locations.*')
                    ->with('zone')
                    ->with('locationTurns.turn')
                    ->join('zones','locations.zone_id','=','zones.id')
                    ->where('zones.project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
                    
        return Inertia::render('Production/WorkBook/Locations/Index', [
            'zones' => $zones,
            'locations' => $locations,
            'turns' => $turns
        ]);
    }

    public function getAvailableTurnsLocation(Request $request, $id) {

        if($request->ajax()){

            $location = Location::find($id);

            $usedTurns = $location->turns;

            $turns = Turn::select('turns.*')
                        ->where('project_id',session('current_project_id'))
                        ->get();

            $availableTurns = [];

            foreach ($turns as $turn){
                $exist = false;
                foreach($usedTurns as $usedTurn)
                {
                    if($usedTurn->turn_id==$turn->id){
                        $exist = true;
                        break;
                    }
                }
                if (!$exist){
                    array_push($availableTurns,$turn);
                }
            }
            return response()->json($availableTurns);
        }
    }
}
