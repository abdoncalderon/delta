<?php

namespace App\Http\Middleware;

use App\Models\Menu;
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
        $currentPerson = null;
        $projectsUser = null;
        $currentProject = null;
        $currentProjectUser = null;
        $menusRole = null;
        $myNeedRequests = 0;
        $myApprovals = 0;
        $myQuotationRequests = 0;

        if (Auth::check()) {

            $currentProjectUser = ProjectUser::select('project_users.*')
                ->where('user_id', $request->user()->id )
                ->where('project_id', session('current_project_id') )
                ->first();

            $currentPerson = Person::select('people.*')
                ->join('users','people.id','=','users.person_id')
                ->where('users.id', $request->user()->id)
                ->first();

            $projectsUser = Project::select('projects.*')
                ->join('project_users','projects.id','=','project_users.project_id')
                ->where('project_users.user_id',$request->user()->id)
                ->get();

            if ($currentProjectUser != null) {

                $currentProject = ProjectUser::select('projects.id as id','projects.name as name')
                    ->join('projects','project_users.project_id','=','projects.id')
                    ->where('project_users.id', $currentProjectUser->id)
                    ->first();

                session(['current_project_user' => $currentProjectUser]);

                $menusRole = Menu::select('menus.*')
                    ->join('menu_roles','menus.id','=','menu_roles.menu_id')
                    ->where('role_id', $currentProjectUser->role_id)
                    ->with('menus')
                    ->get();

                $myNeedRequests = my_pending_requests();

                $myApprovals = my_pending_approvals_requests();

                $myQuotationRequests = my_quotation_requests();
            }
        
        }
        
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'currentPerson'=>$currentPerson,
                'projectsUser'=>$projectsUser,
                'currentProject'=>$currentProject,
                'currentProjectUser'=>$currentProjectUser,
                'myNeedRequests'=>$myNeedRequests,
                'myApprovals'=>$myApprovals,
                'myQuotationRequests'=>$myQuotationRequests,
                'menusRole'=>$menusRole
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

