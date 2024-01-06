<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'project_id'=>'required',
            'name'=>'required',
            'ipAddress'=>'required|max:15',
            'port'=>'required|max:6',
        ];
    }
}
