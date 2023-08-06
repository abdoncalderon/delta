<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:projects,name',
            'code'=>'required|unique:projects,code',
            'taxId'=>'nullable',
            'city_id'=>'required',
            'address'=>'nullable',
            'zipCode'=>'nullable',
            'phoneNumber'=>'nullable',
            'subsidiary_id'=>'required',
            'startDate'=>'nullable',
            'finishDate'=>'nullable',
            'stakeholderLogo1_id'=>'nullable',
            'stakeholderLogo2_id'=>'nullable',
            'stakeholderLogo3_id'=>'nullable',
            'stakeholderLogo4_id'=>'nullable',
        ];
    }
}
