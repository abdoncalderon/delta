<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StorePersonRequest;
use App\Http\Requests\People\UpdatePersonRequest;
use App\Models\Funct1on;
use App\Models\Person;
use App\Models\Region;
use App\Models\Sector;
use App\Models\Stakeholder;
use App\Models\StakeholderPerson;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PersonController extends Controller
{
    public function index() {
        $people = Person::select(DB::raw("people.id as id, CONCAT(people.uid,' - ',people.fullName) as name"))
            ->orderBy('name')
            ->get();
        $regions = Region::get();
        $functions = Funct1on::where('project_id',session('current_project_id'))->get();
        $sectors = Sector::where('project_id',session('current_project_id'))->get();
        $stakeholders = Stakeholder::where('project_id',session('current_project_id'))->get();
        $projectPeople = Person::select('people.*','stakeholders.name as stakeholder')
            ->join('stakeholder_people','people.id','=','stakeholder_people.person_id')
            ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
            ->where('stakeholders.project_id', session('current_project_id'))
            ->where('people.id','!=',1)
            ->get(); 
       
        return Inertia::render('People/Person/Index', [
            'projectPeople' => $projectPeople,
            'regions' => $regions,
            'functions' => $functions,                                                                        
            'sectors' => $sectors,            
            'stakeholders' => $stakeholders,
            'people'=> $people,
        ]);
    }

    public function store(StorePersonRequest $request)
    {
        try{
            $request ->validated();

            if (strrpos($request->lastName,' ')>0) {
                $username=strtolower(substr($request->firstName,0,1).substr($request->lastName,0,strrpos($request->lastName,' ')).substr($request->uid,strlen($request->uid)-2,2));
            } else {
                $username=strtolower(substr($request->firstName,0,1).$request->lastName.substr($request->uid,strlen($request->uid)-2,2));
            }
                
            
            if($request->hasFile('photo'))
            {
                $file = $request->file('photo');
                $photoFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/people/photos/',$photoFileName);
            }else{
                $photoFileName = 'noPhoto.png';
            }

            if($request->hasFile('signature'))
            {
                $file = $request->file('signature');
                $signatureFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/people/signatures/',$signatureFileName);
            }else{
                $signatureFileName = 'noSignature.png';
            }
            
            $person = Person::create([
                'firstName'=>$request->firstName,
                'lastName'=>$request->lastName,
                'fullName'=>$request->fullName,
                'uid'=>$request->uid,
                'gender_id'=>$request->gender_id,
                'birthDate'=>$request->birthDate,
                'jobTitle'=>$request->jobTitle,
                'email'=>$request->email,
                'photo'=>$photoFileName,
                'signature'=>$signatureFileName,
                'isActive'=>'1',
            ]);

            User::create([
                'user'=>$username,
                'email'=>$request->email,
                'password' => Hash::make($request->uid),
                'person_id'=>$person->id,
            ]);

            StakeholderPerson::create([
                'stakeholder_id'=>$request->stakeholder_id,
                'person_id'=>$person->id,
                'admissionDate'=>$request->admissionDate,
                'cardNo'=>$request->cardNo,
                'hiredSince'=>$request->hiredSince,
                'position_id'=>$request->position_id,
                'department_id'=>$request->department_id,
            ]);

            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdatePersonRequest $request, Person $person)
    {
        try{
            $request ->validated();
            
            if($request->hasFile('photo'))
            {
                $file = $request->file('photo');
                $photoFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/people/photos/',$photoFileName);
            }else{
                $photoFileName = $request->photo;
            }

            if($request->hasFile('signature'))
            {
                $file = $request->file('signature');
                $signatureFileName = time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/storage/kapatax/images/people/signatures/',$signatureFileName);
            }else{
                $signatureFileName = $request->signature;
            }
            
            $person->update([
                'firstName'=>$request->firstName,
                'lastName'=>$request->lastName,
                'fullName'=>$request->fullName,
                'uid'=>$request->uid,
                'gender_id'=>$request->gender_id,
                'birthDate'=>$request->birthDate,
                'jobTitle'=>$request->jobTitle,
                'email'=>$request->email,
                'photo'=>$photoFileName,
                'signature'=>$signatureFileName,
            ]);

            return redirect()->back();
        } catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    public function getPerson(Request $request, $id)
    {
        if($request->ajax())
        {
            $person = Person::find($id);
            return response()->json($person);
        }
    }


}
