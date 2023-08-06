<?php

namespace App\Http\Controllers\Settings;

use App\Models\Permit;
use App\Models\Menu;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\StorePermitRequest;
use App\Http\Requests\Settings\UpdatePermitRequest;

use Exception;

class PermitController extends Controller
{
    public function index()
    {
        $menus = Menu::get();
        $permits = Permit::with('menu')->orderBy('name')->get();
        return Inertia::render('Settings/Permits/Index', [
            'permits' => $permits,
            'menus' => $menus,
        ]);
    }

    public function store(StorePermitRequest $request) {
        try{
            Permit::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdatePermitRequest $request, Permit $permit) {
        try{
            $permit->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Permit $permit){
        try{
            $permit->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
