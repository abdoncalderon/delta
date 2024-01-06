<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use Inertia\Inertia;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return Inertia::render('Dashboard');
    }

    public function selectProject() {
        return Inertia::render('Session/SelectProject');
    }
    
    public function setCurrentProject(Request $request)
    {
        session()->put('current_project_id',$request->project_id);
        return redirect()->route('dashboard');
    } 

    
}
