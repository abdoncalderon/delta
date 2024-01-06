<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'user_id'=>'required',
            'role_id'=>'required',
            'user'=>'required',
            'email'=>'required',
            'isActive'=>'nullable',
        ];
    }
}
