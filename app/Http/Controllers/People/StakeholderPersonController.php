<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\StoreStakeholderPersonRequest;
use App\Http\Requests\People\UpdatePersonRequest;
use App\Http\Requests\People\UpdateStakeholderPersonRequest;
use App\Models\Person;
use App\Models\StakeholderPerson;
use Exception;
use Illuminate\Http\Request;

class StakeholderPersonController extends Controller
{
    public function store(StoreStakeholderPersonRequest $request){
        try{
            $person = Person::find($request->person_id);
            if(!is_active_stakeholder_person($person)){
                if(is_valid_date_for_new_admission($request->admissionDate, $request->person_id)&&(is_valid_date_for_project($request->admissionDate, current_user()->project))){
                    $stakeholderPerson = StakeholderPerson::create($request ->validated());
                    $stakeholderPerson->person->update([
                        'isActive' => '1',
                    ]);
                    return redirect()->back();
                }else{
                    return back()->withErrors(__('messages.admissionDateNoValid'));
                }
            }else{
                return back()->withErrors(__('messages.userIsActive').' - '.__('messages.admissionNotPermit'));
            }
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function update(UpdateStakeholderPersonRequest $request, StakeholderPerson $stakeholderPerson) {
        try{   
            if(is_null($request->departureDate)){
                if ((is_valid_date_for_edit_admission($request->admissionDate, $stakeholderPerson)) && 
                    (is_valid_date_for_project($request->admissionDate,current_user()->project))) {
                        $stakeholderPerson->update($request->validated());
                        return redirect()->back();
                } else {
                    return back()->withErrors(__('messages.admissionDateNoValid'));
                }
            } else {
                if ((is_valid_date_for_edit_admission($request->admissionDate, $stakeholderPerson)) &&
                    (is_valid_date_for_edit_admission($request->departureDate, $stakeholderPerson)) &&
                    (is_valid_date_for_project($request->admissionDate,current_user()->project)) &&
                    (is_valid_date_for_project($request->departureDate,current_user()->project))) {
                        
                        $request->validated();
                        $stakeholderPerson->update([
                            'admissionDate'=>$request->admissionDate,
                            'departureDate'=>$request->departureDate,
                            'position_id'=>$request->position_id,
                            'department_id'=>$request->department_id,
                            'businessEmail'=>$request->businessEmail,
                            'cardNo'=>$request->cardNo,
                            'hiredSince'=>$request->hiredSince,
                            'hiredUntil'=>$request->hiredUntil,
                            'salary'=>$request->salary,
                            'isActive'=>'0',
                        ]);
                        return redirect()->back();
                        
                } else {
                    return back()->withErrors(__('messages.dateRangeError1'));
                }
            }
            


            $stakeholderPerson->update($request ->validated());
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function destroy(StakeholderPerson $stakeholderPerson){
        try{
            $stakeholderPerson->delete();
            return redirect()->back();
        }catch(Exception $e){
            return back()->withErrors( $e->getMessage());
        }
    }

    public function getContracts(Request $request, $id)
    {
        if($request->ajax())
        {
            $contracts = StakeholderPerson::select('stakeholder_people.*')
                ->with('stakeholder')
                ->with('person')
                ->with('department')
                ->with('position')
                ->with('leader')
                ->join('people','stakeholder_people.person_id','=','people.id')
                ->join('stakeholders','stakeholder_people.stakeholder_id','=','stakeholders.id')
                ->join('departments','stakeholder_people.department_id','=','departments.id')
                ->join('positions','stakeholder_people.position_id','=','positions.id')
                ->where('stakeholders.project_id', session('current_project_id'))
                ->where('stakeholder_people.person_id', $id)
                ->get(); 
            return response()->json($contracts);
        }
    }

    public function getStakeholderPeople(Request $request, $id)
    {
        if($request->ajax())
        {
            $stakeholderPeople = StakeholderPerson::select('stakeholder_people.id as id', 'people.fullName as name', 'stakeholder_people.cardNo')
                ->join('people','stakeholder_people.person_id','=','people.id')
                ->where('stakeholder_people.stakeholder_id', $id)
                ->get(); 
            return response()->json($stakeholderPeople);
        }
    }


}
