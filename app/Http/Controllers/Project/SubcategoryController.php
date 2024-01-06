<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Imports\SubcategoriesImport;
use App\Http\Requests\Project\StoreSubcategoryRequest;
use Illuminate\Http\Request;
use Exception;

class SubcategoryController extends Controller
{
    public function store(StoreSubcategoryRequest $request )
    {
        try{
            Subcategory::create($request ->validated());
            return back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function import(Request $request){
        try{
            
            if($request->hasFile('file')){
                $file = $request->file('file');
                $import = new SubcategoriesImport;
                $import->import($file);
                if($import->failures()->isNotEmpty()){
                    return back()->withFailures($import->failures());
                }else{
                    return back()->with('success',__('messages.successfullImport'));
                }
            }
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getSubcategories(Request $request, $id)
    {
        if($request->ajax())
        {
            $subcategories = Subcategory::where('category_id',$id)->get();
            return response()->json($subcategories);
        }
    }

    
}
