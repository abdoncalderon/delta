<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Folio;

class StoreFolioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'date'=>'required',
            'location_id'=>'required',
            'project_user_id'=>'required',
            'number'=>'required',
        ];
    }

    
}
