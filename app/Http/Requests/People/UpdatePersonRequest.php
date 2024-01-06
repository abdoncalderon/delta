<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'uid'=>'required|min:8',
            'firstName'=>'required',
            'lastName'=>'required',
            'fullName'=>'nullable',
            'gender_id'=>'required',
            'birthDate'=>'required',
            'jobTitle'=>'nullable',
            'email'=>'nullable|email',
            'photo'=>'nullable',
            'signature'=>'nullable',
        ];
    }
}
