<?php

namespace App\Http\Controllers\Project;

use App\Models\Sector;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreDepartmentRequest;
use App\Http\Requests\Project\UpdateDepartmentRequest;
use App\Imports\DepartmentsImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class DepartmentController extends Controller
{
    public function index()
    {
        $sectors = Sector::where('project_id',session('current_project_id'))->get();
        $departments = Department::select('departments.*')
                    ->with('sector')
                    ->join('sectors','departments.sector_id','=','sectors.id')
                    ->where('sectors.project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
        return Inertia::render('Project/Departments/Index', [
            'sectors' => $sectors,
            'departments' => $departments,
        ]);
    }

    public function store(StoreDepartmentRequest $request) {
        try{
            Department::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateDepartmentRequest $request, Department $department) {
        try{
            $department->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Department $department){
        try{
            $department->delete();
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
                $import = new DepartmentsImport;
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
