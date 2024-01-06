<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\City;
use App\Models\Subsidiary;
use App\Models\Stakeholder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreProjectRequest;
use App\Http\Requests\Settings\UpdateProjectRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
   

    public function edit()
    {
        $project = Project::select(DB::raw("projects.*, regions.id as region_id, countries.id as country_id, states.id as state_id"))
            ->with('subsidiary')
            ->join('cities','projects.city_id','=','cities.id')
            ->join('states','cities.state_id','=','states.id')
            ->join('countries','states.country_id','=','countries.id')
            ->join('regions','countries.region_id','=','regions.id')
            ->where('projects.id',session('current_project_id'))
            ->first();
        $regions = Region::orderBy('name')->get();
        $stakeholders = Stakeholder::get();
        return Inertia::render('Project/Project/Edit', [
            'project' => $project,
            'regions' => $regions,
            'stakeholders' => $stakeholders,
        ]);
    }

    public function getProject(Request $request, $id) {
        if($request->ajax())
        {
            $project = Project::where('id',$id)->with('subsidiary')->first();
            return response()->json($project);
        }
    }
}
