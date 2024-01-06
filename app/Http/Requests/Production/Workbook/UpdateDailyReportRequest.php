<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'folio_id'=>'required',
            'turn_id'=>'required',
            'report'=>'required',
            'project_user_id'=>'required',
            'responsible'=>'nullable',
        ];
    }
}
