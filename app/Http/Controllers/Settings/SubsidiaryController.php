<?php

namespace App\Http\Controllers\Settings;

use App\Models\Subsidiary;
use App\Models\Company;
use App\Models\Division;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreSubsidiaryRequest;
use App\Http\Requests\Settings\UpdateSubsidiaryRequest;
use Illuminate\Http\Request;
use Exception;


class SubsidiaryController extends Controller
{
    public function index()
    {
        $companies = Company::get();
        $divisions = Division::get();
        $subsidiaries = Subsidiary::with('company')->with('division')->orderBy('name')->get();
        return Inertia::render('Settings/Subsidiaries/Index', [
            'subsidiaries' => $subsidiaries,
            'companies' => $companies,
            'divisions' => $divisions,
        ]);
    }

    public function store(StoreSubsidiaryRequest $request) {
        try{
            Subsidiary::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateSubsidiaryRequest $request, Subsidiary $subsidiary) {
        try{
            $subsidiary->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Subsidiary $subsidiary){
        try{
            $subsidiary->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }   
    }
}
