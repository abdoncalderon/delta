<?php

namespace App\Http\Controllers\Settings;

use App\Models\Unity;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreUnityRequest;
use App\Http\Requests\Settings\UpdateUnityRequest;
use App\Imports\UnitiesImport;
use Illuminate\Http\Request;
use Exception;

class UnityController extends Controller
{
    public function index()
    {
        $unities = Unity::orderBy('name')->get();
        return Inertia::render('Settings/Unities/Index', [
            'unities' => $unities
        ]);
    }

    public function store(StoreUnityRequest $request) {
        try{
            Unity::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateUnityRequest $request, Unity $unity) {
        try{
            $unity->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Unity $unity){
        try{
            $unity->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try{
            
            if($request->hasFile('file')){
                $file = $request->file('file');
                $import = new UnitiesImport;
                $import->import($file);
                if($import->failures()->isNotEmpty()){
                    return redirect()->back()->withErrors($import->failures());
                }else{
                    return redirect()->back();
                }
            }
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
