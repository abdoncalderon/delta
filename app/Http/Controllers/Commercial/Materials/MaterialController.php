<?php

namespace App\Http\Controllers\Commercial\Materials;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commercial\StoreMaterialRequest;
use App\Http\Requests\Commercial\UpdateMaterialRequest;
use App\Models\Asset;
use App\Models\Brand;
use App\Models\Family;
use App\Models\Material;
use App\Models\Mode1;
use App\Models\Unity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index() {
        $brands = Brand::get();
        $models = Mode1::get();
        $unities = Unity::get();
        $families = Family::select('families.*')
                    ->where('project_id',session('current_project_id'))
                    ->get();
        $materials = Material::select(DB::raw("materials.*, families.id as family_id, categories.id as category_id, brands.id as brand_id, CONCAT(subcategories.name,' - ', brands.name,' - ',mode1s.name) as material"))    
            ->join('subcategories','materials.subcategory_id','=','subcategories.id')
            ->join('categories','subcategories.category_id','=','categories.id')
            ->join('families','categories.family_id','=','families.id')
            ->join('mode1s','materials.model_id','=','mode1s.id')
            ->join('brands','mode1s.brand_id','=','brands.id')
            ->join('unities','materials.unity_id','=','unities.id')
            ->where('materials.project_id',session('current_project_id'))
            ->get();
        
        return Inertia::render('Commercial/Materials/Materials/Index', [
            'materials' => $materials,
            'families' => $families,
            'brands' => $brands,
            'models' => $models,
            'unities' => $unities,
        ]);
    }

    public function store(StoreMaterialRequest $request)
    {
        try{
            Material::create($request->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        try{
            $material->update($request->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
