<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Family;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreFamilyRequest;
use App\Http\Requests\Project\UpdateFamilyRequest;
use App\Imports\FamiliesImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class FamilyController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $families = Family::with('project')
                ->where('project_id',session('current_project_id'))
                ->orderBy('name')
                ->get();
        return Inertia::render('Project/Families/Index', [
            'projects' => $projects,
            'families' => $families,
        ]);
    }

    public function store(StoreFamilyRequest $request) {
        try{
            Family::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateFamilyRequest $request, Family $family) {
        try{
            $family->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Family $family){
        try{
            $family->delete();
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
                $import = new FamiliesImport;
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
