<?php

namespace App\Http\Controllers\Settings;

use App\Models\Region;
use App\Models\Country;
use App\Models\State;
use App\Http\Controllers\Controller;
use App\Imports\CountriesImport;
use App\Http\Requests\Settings\StoreCountryRequest;
use App\Http\Requests\Settings\UpdateCountryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class CountryController extends Controller
{
    public function index()
    {
        $regions = Region::get();
        $countries = Country::with('region')->orderBy('name')->get();
        return Inertia::render('Settings/Countries/Index', [
            'countries' => $countries,
            'regions' => $regions,
        ]);
    }

    public function store(StoreCountryRequest $request) {
        try{
            Country::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateCountryRequest $request, Country $country) {
        try{
            $country->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Country $country){
        try{
            $country->delete();
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
                $import = new CountriesImport;
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

    

    public function getCountries(Request $request, $id)
    {
        if($request->ajax())
        {
            $countries = Country::where('region_id',$id)->orderBy('name')->get();
            return response()->json($countries);
        }
    }

    

}
