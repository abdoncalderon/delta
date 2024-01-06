<?php

namespace App\Http\Requests\Production\Workbook;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\EquipmentDailyReport;

class StoreEquipmentDailyReportRequest extends FormRequest
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
            'equipment_id'=>'required',
            'quantity'=>'required',
        ];
    }

}
