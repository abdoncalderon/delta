<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
            'name'=>'required|unique:menus,name',
            'text'=>'required',
            'route'=>'nullable',
            'father'=>'nullable',
            'icon'=>'nullable',
        ];
    }
}
