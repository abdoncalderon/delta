<?php

namespace App\Http\Controllers\Settings;
use App\Models\Menu;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\StoreMenuRequest;
use App\Http\Requests\Settings\UpdateMenuRequest;
use Illuminate\Support\Facades\Route;
use Exception;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('menu')->orderBy('father')->get();
        return Inertia::render('Settings/Menus/Index', [
            'menus' => $menus
        ]);
    }

    public function store(Request $request )
    {
        try{
            $request->validated();
            if($this->checkRoute($request->route)){
                $menu = Menu::create([
                    'code'=>$request->code,
                    'showName'=>$request->showName,
                    'father'=>$request->father,
                    'route'=>$request->route,
                    'icon'=>$request->icon,
                ]);
                return redirect()->back();
            }else{
                return back();
            }
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    /* public function store(StoreMenuRequest $request) {
        try{
            Menu::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    } */

    public function update(UpdateMenuRequest $request, Menu $menu) {
        try{
            $menu->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Menu $menu){
        try{
            $menu->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    private function checkRoute($route) {
        return Route::has($route);
    }

    
}
