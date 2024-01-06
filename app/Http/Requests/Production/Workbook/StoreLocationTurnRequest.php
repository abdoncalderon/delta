<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationTurnRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'turns'=>'required',
            'location_id'=>'required',
            'dateFrom'=>'required',
            'dateTo'=>'required',
        ];
    }
}
