<?php

namespace App\Http\Controllers\Project;

use App\Models\Funct1on;
use App\Models\Position;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StorePositionRequest;
use App\Http\Requests\Project\UpdatePositionRequest;
use Illuminate\Http\Request;
use App\Imports\PositionsImport;
use Inertia\Inertia;
use Exception;


class PositionController extends Controller
{
    public function index()
    {
        $functions = Funct1on::where('project_id',session('current_project_id'))->get();
        $positions = Position::select('positions.*')
                    ->with('function')
                    ->join('funct1ons','positions.function_id','=','funct1ons.id')
                    ->where('funct1ons.project_id',session('current_project_id'))
                    ->orderBy('name')
                    ->get();
        return Inertia::render('Project/Positions/Index', [
            'functions' => $functions,
            'positions' => $positions,
        ]);
    }

    public function store(StorePositionRequest $request) {
        try{
            Position::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdatePositionRequest $request, Position $position) {
        try{
            $position->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Position $position){
        try{
            $position->delete();
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
                $import = new PositionsImport;
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
