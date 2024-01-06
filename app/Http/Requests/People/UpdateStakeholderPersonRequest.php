<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStakeholderPersonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'admissionDate'=>'required',
            'departureDate'=>'nullable|date|after_or_equal:admissionDate',
            'position_id'=>'required',
            'department_id'=>'required',
            'leader_id'=>'nullable',
            'businessEmail'=>'nullable',
            'cardNo'=>'required',
            'hiredSince'=>'nullable',
            'hiredUntil'=>'nullable|date|after_or_equal:hiredSince',
            'salary'=>'nullable',
            'isApprover'=>'nullable',
        ];
    }
}
