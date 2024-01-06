<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionDailyReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'daily_report_id'=>'required',
            'stakeholder_id'=>'required',
            'position_id'=>'required',
            'quantity'=>'required',
        ];
    }
    
}
