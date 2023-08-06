<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use App\Models\Menu;
use App\Models\User;
use Inertia\Inertia;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return Inertia::render('Dashboard');
    }

    public function selectProject() {
        return Inertia::render('SelectProject');
    }

    public function getCurrentProject(Request $request) {
        if($request->ajax())
        {
            $currentProjectId = session('current_project_id');
            return response()->json($currentProjectId);
        }
    } 

    public function setCurrentProject(Request $request)
    {
        session(['current_project_id' => $request->project_id]);
        return redirect()->route('dashboard');
    }



    
}
