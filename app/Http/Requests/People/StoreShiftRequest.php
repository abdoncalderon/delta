<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'name'=>'required',
            'start'=>'required',
            'finish'=>'required',
            'nextday'=>'nullable',
            'breaktime'=>'required',
            'earlyCheckin'=>'required',
            'lateCheckout'=>'required',
            'overtime'=>'required',
            'project_id'=>'required',
        ];
    }
}
