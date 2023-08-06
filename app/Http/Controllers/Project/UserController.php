<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Role;
use App\Models\Person;
use App\Models\ProjectUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectUserRequest;
use App\Http\Requests\Project\UpdateProjectUserRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;


class UserController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $roles = Role::get();
        $people = Person::select('users.id as id','people.fullName as name')
                    ->join('users','people.id','=','users.person_id')
                    ->join('project_users','users.id','=','project_users.user_id')
                    ->where('project_users.project_id',session('current_project_id'))
                    ->get(); 
        $users = ProjectUser::with('user')
                        ->with('project')
                        ->with('role')
                        ->where('project_id',session('current_project_id'))
                        ->get();
        return Inertia::render('Project/Users/Index', [
            'projects' => $projects,
            'users' => $users,
            'roles' => $roles,
            'people' => $people,
        ]);
    }

    public function store(StoreProjectUserRequest $request) {
        try{
            ProjectUser::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateProjectUserRequest $request, ProjectUser $projectUser) {
        try{
            $projectUser->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    } 

    public function destroy(ProjectUser $projectUser){
        try{
            $projectUser->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage() );
        }
    }
}
