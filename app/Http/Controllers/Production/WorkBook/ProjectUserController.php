<?php

namespace App\Http\Controllers\Production\WorkBook;

use App\Http\Controllers\Controller;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class ProjectUserController extends Controller
{
    public function index()
    {
        $projectUsers = ProjectUser::select('project_users.id as id','people.fullName as name','stakeholders.name as stakeholder')
            ->join('users','project_users.user_id','=','users.id')
            ->join('people','users.person_id','=','people.id')
            ->join('stakeholder_people','people.id','=','stakeholder_people.person_id')
            ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
            ->where('project_users.project_id', session('current_project_id'))
            ->orderBy('name')
            ->get();  
        /*  */
        return Inertia::render('Production/WorkBook/Users/Index', [
            'projectUsers' => $projectUsers,
            
        ]);
    }
}
