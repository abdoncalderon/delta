<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class StoreClockRequest extends FormRequest
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
            'ipAddress'=>'required|ipv4',
            'port'=>'required|integer|max:65535',
        ];
    }
}
