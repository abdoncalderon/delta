<?php

namespace App\Http\Controllers\Settings;

use App\Models\Project;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreProjectRequest;
use App\Http\Requests\Settings\UpdateProjectRequest;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class ProjectController extends Controller
{
    public function index()
    {
        $subsidiaries = Subsidiary::get();
        $cities = City::get();
        $projects = Project::with('subsidiary')->with('city')->orderBy('name')->get();
        return Inertia::render('Settings/Projects/Index', [
            'projects' => $projects,
            'subsidiaries' => $subsidiaries,
            'cities' => $cities,
        ]);
    }

    public function store(StoreProjectRequest $request) {
        try{
            Project::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateProjectRequest $request, Project $project) {
        try{
            $project->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Project $project){
        try{
            $project->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
    
    
}
