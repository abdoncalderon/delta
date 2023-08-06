<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'name'=>'required',
            'zone_id'=>'required',
            'code'=>'required',
            'latitude'=>'nullable',
            'longitude'=>'nullable',
            'startDate'=>'required',
            'finishDate'=>'required|after:startDate',
        ];
    }
}
