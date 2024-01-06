<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class StorePhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'person_id'=>'required',
            'type_id'=>'required',
            'country_id'=>'required',
            'number'=>'required',
        ];
    }
}
