<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreEquipmentRequest;
use App\Http\Requests\Project\UpdateEquipmentRequest;
use App\Imports\EquipmentsImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;


class EquipmentController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $equipments = Equipment::with('project')
                    ->where('project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
        return Inertia::render('Project/Equipments/Index', [
            'projects' => $projects,
            'equipments' => $equipments,
        ]);
    }

    public function store(StoreEquipmentRequest $request) {
        try{
            Equipment::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment) {
        try{
            $equipment->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Equipment $equipment){
        try{
            $equipment->delete();
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
                $import = new EquipmentsImport;
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
