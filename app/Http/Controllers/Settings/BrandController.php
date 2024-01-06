<?php

namespace App\Http\Controllers\Settings;

use App\Models\Brand;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Imports\BrandsImport;
use App\Http\Requests\Settings\StoreBrandRequest;
use App\Http\Requests\Settings\UpdateBrandRequest;
use App\Models\Mode1;
use Illuminate\Http\Request;
use Exception;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        return Inertia::render('Settings/Brands/Index', [
            'brands' => $brands
        ]);
    }

    public function store(StoreBrandRequest $request) {
        try{
            Brand::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateBrandRequest $request, Brand $brand) {
        try{
            $brand->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Brand $brand){
        try{
            $brand->delete();
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
                $import = new BrandsImport;
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
