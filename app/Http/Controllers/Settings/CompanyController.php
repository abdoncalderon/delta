<?php

namespace App\Http\Controllers\Settings;
use App\Models\Company;
use Inertia\Inertia;

use App\Http\Requests\Settings\StoreRegionRequest;
use App\Http\Requests\Settings\UpdateRegionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->get();
        return Inertia::render('Settings/Companies/Index', [
            'companies' => $companies
        ]);
    }

    public function store(StoreRegionRequest $request) {
        try{
            Company::create($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateRegionRequest $request, Company $company) {
        try{
            $company->update($request->input());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(Company $company){
        try{
            $company->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
