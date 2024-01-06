<?php

namespace App\Imports;

use App\Models\Shift;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ShiftsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        return new Shift([
            'name' => $row['name'],
            'start' => Carbon::createFromTimeString($row['start']),
            'finish' => Carbon::createFromTimeString($row['finish']),
            'nextday' => $row['next_day'],
            'project_id' => session('current_project_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name'=> ['string'],
            '*.start'=> ['date_format:H:i:s'],
            '*.finish'=> ['date_format:H:i:s'],
            '*.next_day'=> ['integer'],
        ];
    }
}
