<?php

namespace App\Http\Controllers\Settings;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreStateRequest;
use App\Http\Requests\Settings\UpdateStateRequest;
use App\Imports\StatesImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class StateController extends Controller
{
    public function index()
    {
        $countries = Country::get();
        $states = State::with('country')->orderBy('name')->get();
        return Inertia::render('Settings/States/Index', [
            'states' => $states,
            'countries' => $countries,
        ]);
    }

    public function store(StoreStateRequest $request) {
        try{
            State::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateStateRequest $request, State $state) {
        try{
            $state->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(State $state){
        try{
            $state->delete();
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
                $import = new StatesImport;
                $import->import($file);
                if($import->failures()->isNotEmpty()){
                    dd($import->failures());
                    return redirect()->back()->withErrors($import->failures());
                }else{
                    return redirect()->back();
                }
            }
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getStates(Request $request, $id)
    {
        if($request->ajax())
        {
            $states = State::where('country_id',$id)->orderBy('name')->get();
            return response()->json($states);
        }
    }


    
}
