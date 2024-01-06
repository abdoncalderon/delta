<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentDailyReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'daily_report_id'=>'required',
            'file'=>'required',
            'description'=>'nullable',
            'project_user_id'=>'required',
        ];
    }
    
}
