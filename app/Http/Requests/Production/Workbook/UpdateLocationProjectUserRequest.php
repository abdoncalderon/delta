<?php

namespace App\Http\Requests\Production\WorkBook;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationProjectUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profile'=>'required',
            'receive_notification'=>'nullable',
        ];
    }
}
