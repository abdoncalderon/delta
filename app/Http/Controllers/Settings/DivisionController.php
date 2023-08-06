<?php

namespace App\Http\Controllers\Settings;

use App\Models\Division;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreDivisionRequest;
use App\Http\Requests\Settings\UpdateDivisionRequest;
use Illuminate\Http\Request;
use Exception;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::orderBy('name')->get();
        return Inertia::render('Settings/Divisions/Index', [
            'divisions' => $divisions
        ]);
    }

    public function store(StoreDivisionRequest $request) {
        try{
            Division::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateDivisionRequest $request, Division $region) {
        try{
            $region->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Division $region){
        try{
            $region->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
