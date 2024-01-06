<?php

namespace App\Http\Controllers\Project;
use App\Models\Project;
use App\Models\Stakeholder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreStakeholderRequest;
use App\Http\Requests\Project\UpdateStakeholderRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;

class StakeholderController extends Controller
{
    public function index()
    {
        $project = Project::find(session('current_project_id'));
        $regions = Region::orderBy('name')->get();
        $stakeholders = Stakeholder::select(DB::raw("stakeholders.*, regions.id as region_id, countries.id as country_id, states.id as state_id"))
            ->with('project')
            ->with('city')
            ->join('cities','stakeholders.city_id','=','cities.id')
            ->join('states','cities.state_id','=','states.id')
            ->join('countries','states.country_id','=','countries.id')
            ->join('regions','countries.region_id','=','regions.id')
            ->where('project_id',session('current_project_id'))
            ->orderBy('name')
            ->get();

        return Inertia::render('Project/Stakeholders/Index', [
            'stakeholders' => $stakeholders,
            'project' => $project,
            'regions' => $regions,
        ]);
    }

    public function store(StoreStakeholderRequest $request) {
        try{
            $request ->validated();
            if($request->hasFile('logofile')){
                $file = $request->file('logofile');
                $logoFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/project/stakeholders/',$logoFileName);
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
                $file->move(public_path().'/storage/kapatax/images/project/stakeholders/',$logoFileName);
                
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
