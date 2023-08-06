<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Sector;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreSectorRequest;
use App\Http\Requests\Project\UpdateSectorRequest;
use App\Imports\SectorsImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class SectorController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $sectors = Sector::with('project')
                        ->where('sectors.project_id',session('current_project_id'))
                        ->orderBy('name')
                        ->get();
        return Inertia::render('Project/Sectors/Index', [
            'projects' => $projects,
            'sectors' => $sectors,
        ]);
    }

    public function store(StoreSectorRequest $request) {
        try{
            Sector::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateSectorRequest $request, Sector $sector) {
        try{
            $sector->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Sector $sector){
        try{
            $sector->delete();
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
                $import = new SectorsImport;
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
