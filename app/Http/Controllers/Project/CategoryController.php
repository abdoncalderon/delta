<?php

namespace App\Http\Controllers\Project;

use App\Models\Family;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreCategoryRequest;
use App\Http\Requests\Project\UpdateCategoryRequest;
use App\Imports\CategoriesImport;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        $families = Family::where('project_id',session('current_project_id'))->get();
        $categories = Category::select('categories.*')
                    ->with('family')
                    ->join('families','categories.family_id','=','families.id')
                    ->where('families.project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
        return Inertia::render('Project/Categories/Index', [
            'families' => $families,
            'categories' => $categories,
        ]);
    }

    public function store(StoreCategoryRequest $request) {
        try{
            Category::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateCategoryRequest $request, Category $category) {
        try{
            $category->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Category $category){
        try{
            $category->delete();
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
                $import = new CategoriesImport;
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

    public function getCategories(Request $request, $id)
    {
        if($request->ajax())
        {
            $categories = Category::where('family_id',$id)->get();
            return response()->json($categories);
        }
    }

    
}
