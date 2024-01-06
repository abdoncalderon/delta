<?php

namespace App\Http\Controllers\Project;

use App\Models\Zone;
use App\Models\Location;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreLocationRequest;
use App\Http\Requests\Project\UpdateLocationRequest;
use App\Imports\LocationsImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class LocationController extends Controller
{
    public function index()
    {
        $zones = Zone::where('project_id',session('current_project_id'))->get();
        $locations = Location::select('locations.*')
                    ->with('zone')
                    ->join('zones','locations.zone_id','=','zones.id')
                    ->where('zones.project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
        return Inertia::render('Project/Locations/Index', [
            'zones' => $zones,
            'locations' => $locations,
        ]);
    }

    public function store(StoreLocationRequest $request) {
        try{
            Location::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateLocationRequest $request, Location $location) {
        try{
            $location->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Location $location){
        try{
            $location->delete();
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
                $import = new LocationsImport;
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

    public function getLocations(Request $request, $id)
    {
        if($request->ajax())
        {
            $locations = Location::where('zone_id',$id)->get();
            return response()->json($locations);
        }
    }
    
}
