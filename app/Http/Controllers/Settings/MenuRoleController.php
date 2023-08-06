<?php

namespace App\Http\Controllers\Settings;
use App\Models\ProjectUser;
use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuRoleController extends Controller
{
    public function getMenusRole(Request $request) {
        if($request->ajax())
        {
            $id = session('current_project_id');
            $projectUser = ProjectUser::where('project_id', $id)
                        ->where('user_id',auth()->user()->id)
                        ->first();
            session(['currentProjectUserId' => $projectUser->id]);
            $menusRole = Menu::select('menus.*')
                        ->join('menu_roles','menus.id','=','menu_roles.menu_id')
                        ->where('role_id', $projectUser->role_id)
                        ->with('menus')
                        ->get();
            
            return response()->json($menusRole);
        }
    }   
}
