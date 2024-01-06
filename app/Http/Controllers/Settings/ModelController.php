<?php

namespace App\Http\Controllers\Settings;

use App\Models\Brand;
use App\Models\Mode1;
use App\Http\Controllers\Controller;
use App\Imports\ModelsImport;
use App\Http\Requests\Settings\StoreModelRequest;
use App\Http\Requests\Settings\UpdateModelRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class ModelController extends Controller
{
    public function index()
    {
        $brands = Brand::get();
        $models = Mode1::with('brand')->orderBy('name')->get();
        return Inertia::render('Settings/Models/Index', [
            'models' => $models,
            'brands' => $brands,
        ]);
    }

    public function store(StoreModelRequest $request) {
        try{
            Mode1::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateModelRequest $request, Mode1 $model) {
        try{
            $model->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Mode1 $model){
        try{
            $model->delete();
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
                $import = new ModelsImport;
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

    public function getModels(Request $request, $id)
    {
        if($request->ajax())
        {
            $models = Mode1::where('brand_id',$id)->get();
            return response()->json($models);
        }
    }
}
