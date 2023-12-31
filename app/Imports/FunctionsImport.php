<?php

namespace App\Imports;

use App\Models\Funct1on;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FunctionsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{

    use Importable, SkipsErrors, SkipsFailures;
    
    public function model(array $row)
    {
        return new Funct1on([
            'name' => $row['name'],
            'project_id' => session('current_project_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name'=> ['string'],
        ];
    }
}
