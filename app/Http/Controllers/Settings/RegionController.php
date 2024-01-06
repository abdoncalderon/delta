<?php

namespace App\Http\Controllers\Settings;

use App\Models\Region;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Imports\RegionsImport;
use App\Http\Requests\Settings\StoreRegionRequest;
use App\Http\Requests\Settings\UpdateRegionRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Exception;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::orderBy('name')->get();
        return Inertia::render('Settings/Regions/Index', [
            'regions' => $regions
        ]);
    }

    public function store(StoreRegionRequest $request) {
        try{
            Region::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateRegionRequest $request, Region $region) {
        try{
            $region->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Region $region){
        try{
            $region->delete();
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
                $import = new RegionsImport;
                $import->import($file);
                if($import->failures()->isNotEmpty()){
                    return redirect()->back()->withErrors($import->failures());
                }else{
                    return redirect()->back();
                }
            }
        }catch(Exception $e){
            return redirect()->back();
        }
    }

    




}
