<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'person_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'postalCode'=>'nullable',
        ];
    }
}
