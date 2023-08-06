<?php

namespace App\Http\Controllers\Settings;

use App\Models\Role;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\StoreRoleRequest;
use App\Http\Requests\Settings\UpdateRoleRequest;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return Inertia::render('Settings/Roles/Index', [
            'roles' => $roles
        ]);
    }

    public function store(StoreRoleRequest $request) {
        try{
            Role::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateRoleRequest $request, Role $role) {
        try{
            $role->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Role $role){
        try{
            $role->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
