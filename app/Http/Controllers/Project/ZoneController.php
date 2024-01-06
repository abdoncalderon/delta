<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Zone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreZoneRequest;
use App\Http\Requests\Project\UpdateZoneRequest;
use App\Imports\ZonesImport;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class ZoneController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $zones = Zone::with('project')
                ->where('project_id',session('current_project_id'))
                ->orderBy('name')
                ->get();
        return Inertia::render('Project/Zones/Index', [
            'projects' => $projects,
            'zones' => $zones,
        ]);
    }

    public function store(StoreZoneRequest $request) {
        try{
            Zone::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateZoneRequest $request, Zone $zone) {
        try{
            $zone->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Zone $zone){
        try{
            $zone->delete();
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
                $import = new ZonesImport;
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

    

}
