<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationProjectUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'locations'=>'required',
            'project_user_id'=>'required',
            'profile'=>'required',
            'receive_notification'=>'nullable',
        ];
    }
}
