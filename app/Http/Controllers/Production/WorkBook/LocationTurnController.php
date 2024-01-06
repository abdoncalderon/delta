<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\LocationTurn;
use App\Models\Turn;
use App\Http\Requests\Production\WorkBook\StoreLocationTurnRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class LocationTurnController extends Controller
{
    public function index(Location $location)
    {
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

        $turnsLocation = LocationTurn::select('location_turns.*')
                ->with('turn')
                ->with('location')
                ->where('location_id',$location->id)
                ->get();
        return Inertia::render('Production/WorkBook/Locations/Turns', [
            'location' => $location,
            'turnsLocation' => $turnsLocation,
            'availableTurns' => $availableTurns
        ]);
    }

    public function store(StoreLocationTurnRequest $request)
    {
        try{
            $location = Location::find($request->location_id);
            if((is_valid_date_for_project($request->dateFrom,current_user()->project))&&(is_valid_date_for_project($request->dateTo,current_user()->project))){
                if((is_valid_date_for_location($request->dateFrom, $location))&&(is_valid_date_for_location($request->dateTo, $location))){
                    // LocationTurn::create($request ->validated());
                    $request->validated();
                    foreach ($request->turns as $turn) {
                        if ($turn['checked']){
                            LocationTurn::create([
                                'location_id' => $request->location_id,
                                'turn_id' => $turn['value']['id'],
                                'dateFrom' => $request->dateFrom,
                                'dateTo' => $request->dateTo,
                            ]);
                        }   
                    }
                    return redirect()->back();
                }else{
                    return back()->withErrors('Error fecha ubicacion');
                }
            }else{
                return back()->withErrors('Error fecha projecto');
            }
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(LocationTurn $locationTurn)
    {
        try{
            $locationTurn->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    


}
