<?php

namespace App\Http\Middleware;
use App\Models\Person;
use App\Models\Project;
use App\Models\ProjectUSer;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    public function share(Request $request)
    {
        $person = null;
        $projectsUser = null;
        $project = null;
        if (Auth::check()) {
            $person = Person::select('people.*')
                    ->join('users','people.id','=','users.person_id')
                    ->where('users.id',$request->user()->id)
                    ->first();

            $projectsUser = Project::select('projects.*')
                        ->join('project_users','projects.id','=','project_users.project_id')
                        ->where('project_users.user_id',$request->user()->id)
                        ->get();
            $project = ProjectUser::select('projects.id as id','projects.name as name')
                        ->join('projects','project_users.project_id','=','projects.id')
                        ->where('project_users.id', session('current_project_id'))
                        ->get();
        }
        
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'person'=>$person,
                'projectsUser'=>$projectsUser,
                'currentProject'=>$project,
            ],
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                ];
            },
            'showingMobileMenu' => false,
            
        ]);
    }
}

