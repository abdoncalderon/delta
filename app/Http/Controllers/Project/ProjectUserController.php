<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectUserRequest;
use App\Http\Requests\Project\UpdateProjectUserRequest;
use App\Models\Location;
use App\Models\LocationProjectUser;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectUserController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $roles = Role::get();
        $users = User::select('users.id as id','people.fullName as name')
                    ->join('people','users.person_id','=','people.id')
                    ->get(); 
        $projectUsers = ProjectUser::select('project_users.*')
                        ->with('user')
                        ->with('project')
                        ->with('role')
                        ->where('project_id',session('current_project_id'))
                        ->get();
        return Inertia::render('Project/Users/Index', [
            'projects' => $projects,
            'projectUsers' => $projectUsers,
            'roles' => $roles,
            'users' => $users,
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
            $projectUser->update([
                'role_id' => $request->role_id,
                'isActive' => $request->isActive,
            ]);
            $user=User::find($request->user_id);
            $user->update([
                'user' => $request->user,
                'email' => $request->email,
            ]);
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
