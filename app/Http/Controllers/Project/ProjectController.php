<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\City;
use App\Models\Subsidiary;
use App\Models\Stakeholder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreProjectRequest;
use App\Http\Requests\Settings\UpdateProjectRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class ProjectController extends Controller
{
   /*  public function index()
    {
        $cities = City::get();
        $projects = Project::with('subsidiary')->with('city')->orderBy('name')->get();
        return Inertia::render('Project/Project/Index', [
            'projects' => $projects,
            'cities' => $cities,
        ]);
    } */

    public function edit()
    {
        $subsidiaries = Subsidiary::get();
        $cities = City::get();
        $stakeholders = Stakeholder::get();
        return Inertia::render('Project/Project/Edit', [
            'subsidiaries' => $subsidiaries,
            'cities' => $cities,
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
