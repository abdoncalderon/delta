<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'firstName'=>'required',
            'lastName'=>'required',
            'fullName'=>'nullable',
            'uid'=>'required|unique:people,uid|min:8',
            'gender_id'=>'required',
            'birthDate'=>'required',
            'jobTitle'=>'nullable',
            'email'=>'nullable|email',
            'photo'=>'nullable',
            'signature'=>'nullable',
            'stakeholder_id'=>'required',
            'admissionDate'=>'required',
            'cardNo'=>'required|numeric',
            'hiredSince'=>'required',
            'position_id'=>'required',
            'department_id'=>'required',
        ];
    }
}
