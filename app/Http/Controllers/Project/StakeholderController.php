<?php

namespace App\Http\Controllers\Project;
use App\Models\Project;
use App\Models\City;
use App\Models\Stakeholder;
use App\Http\Controllers\Controller;
use App\Models\StakeholderType;
use App\Http\Requests\Project\StoreStakeholderRequest;
use App\Http\Requests\Project\UpdateStakeholderRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;

class StakeholderController extends Controller
{
    public function index()
    {
        $projects = Project::get();
        $cities = City::get();
        $stakeholderTypes = StakeholderType::get();
        $stakeholders = Stakeholder::with('project')
                        ->with('city')
                        ->with('stakeholderType')
                        ->where('project_id',session('current_project_id'))
                        ->orderBy('name')
                        ->get();
        return Inertia::render('Project/Stakeholders/Index', [
            'stakeholders' => $stakeholders,
            'projects' => $projects,
            'cities' => $cities,
            'stakeholderTypes' => $stakeholderTypes,
        ]);
    }

    public function store(StoreStakeholderRequest $request) {
        try{
            $request ->validated();
            if($request->hasFile('logofile')){
                $file = $request->file('logofile');
                $logoFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/stakeholders/',$logoFileName);
            }else{
                $logoFileName = 'noPhoto.png';
            }
            Stakeholder::create([
                'name'=>$request->name,
                'project_id'=>$request->project_id,
                'code'=>$request->code,
                'taxId'=>$request->taxId,
                'city_id'=>$request->city_id,
                'address'=>$request->address,
                'zipCode'=>$request->zipCode,
                'email'=>$request->email,
                'phoneNumber'=>$request->phoneNumber,
                'logofile'=>$logoFileName,
                'stakeholder_type_id'=>$request->stakeholder_type_id,
            ]);
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateStakeholderRequest $request, Stakeholder $stakeholder) {
        try{
            $request ->validated();
            if($request->hasFile('logofile')){
                
                $file = $request->file('logofile');
                $logoFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/stakeholders/',$logoFileName);
                
            }else{
                $logoFileName = 'noPhoto.png';
            }
            $stakeholder->update([
                'name'=>$request->name,
                'code'=>$request->code,
                'taxId'=>$request->taxId,
                'city_id'=>$request->city_id,
                'address'=>$request->address,
                'zipCode'=>$request->zipCode,
                'email'=>$request->email,
                'phoneNumber'=>$request->phoneNumber,
                'logofile'=>$logoFileName,
                'stakeholder_type_id'=>$request->stakeholder_type_id,
            ]);
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Stakeholder $stakeholder){
        try{
            $stakeholder->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }
}
