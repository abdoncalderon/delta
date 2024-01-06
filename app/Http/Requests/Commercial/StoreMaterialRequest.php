<?php

namespace App\Http\Requests\Commercial;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'project_id'=>'required',
            'type_id'=>'required',
            'subcategory_id'=>'required',
            'model_id'=>'required',
            'partOf'=>'nullable',
            'name'=>'required',
            'description'=>'nullable',
            'internalCode'=>'required',
            'sku'=>'required',
            'upc'=>'nullable',
            'unity_id'=>'required',
            'weight'=>'nullable|numeric',
            'volume'=>'nullable|numeric',
            'status_id'=>'nullable',
        ];
    }
}
