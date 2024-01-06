<?php

namespace App\Http\Controllers\Project;
use App\Models\Project;
use App\Models\Funct1on;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreFunctionRequest;
use App\Http\Requests\Project\UpdateFunctionRequest;
use Illuminate\Http\Request;
use App\Imports\FunctionsImport;
use App\Models\Position;
use Inertia\Inertia;
use Exception;

class FunctionController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $functions = Funct1on::with('project')
                    ->where('project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
        return Inertia::render('Project/Functions/Index', [
            'projects' => $projects,
            'functions' => $functions,
        ]);
    }

    public function store(StoreFunctionRequest $request) {
        try{
            Funct1on::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateFunctionRequest $request, Funct1on $function) {
        try{
            $function->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Funct1on $function){
        try{
            $function->delete();
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
                $import = new FunctionsImport;
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
