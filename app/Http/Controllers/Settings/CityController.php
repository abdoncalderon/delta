<?php

namespace App\Http\Controllers\Settings;

use App\Models\State;
use App\Models\City;
use App\Http\Requests\Settings\StoreCityRequest;
use App\Http\Requests\Settings\UpdateCityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\CitiesImport;
use Inertia\Inertia;
use Exception;

class CityController extends Controller
{
    public function index()
    {
        $states = State::get();
        $cities = City::with('state')->orderBy('name')->get();
        return Inertia::render('Settings/Cities/Index', [
            'cities' => $cities,
            'states' => $states,
        ]);
    }

    public function store(StoreCityRequest $request) {
        try{
            City::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateCityRequest $request, City $city) {
        try{
            $city->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(City $city){
        try{
            $city->delete();
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
                $import = new CitiesImport;
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

    public function getCities(Request $request, $id)
    {
        if($request->ajax())
        {
            $cities = City::where('state_id',$id)->orderBy('name')->get();
            return response()->json($cities);
        }
    }

    
}
