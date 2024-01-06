<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class StoreStakeholderPersonShiftRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employees'=>'required',
            'shift_id'=>'required',
            'since'=>'required|date',
            'until'=>'required|date|after_or_equal:since',
        ];
    }
}
