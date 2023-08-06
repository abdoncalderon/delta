<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Models\Turn;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreTurnRequest;
use App\Http\Requests\Project\UpdateTurnRequest;
use App\Imports\TurnsImport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class TurnController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $turns = Turn::with('project')
                ->where('project_id',session('current_project_id'))
                ->orderBy('name')
                ->get();
        return Inertia::render('Project/Turns/Index', [
            'projects' => $projects,
            'turns' => $turns,
        ]);
    }

    public function store(StoreTurnRequest $request) {
        try{
            Turn::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateTurnRequest $request, Turn $turn) {
        try{
            $turn->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Turn $turn){
        try{
            $turn->delete();
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
                $import = new TurnsImport;
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
