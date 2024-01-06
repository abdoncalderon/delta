<?php

namespace App\Imports;

use App\Models\Person;
use App\Models\Stakeholder;
use App\Models\StakeholderPerson;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;


class PeopleImport implements ToCollection
{

    private $stakeholders;

    public function __construct()
    {
        $this->stakeholders = Stakeholder::pluck('id','name');
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $person = Person::create([
                'uid' => $row['uid'],
                'firstName' => $row['firstName'],
                'lastName' => $row['lastName'],
                'fullName' => $row['fullName'],
                'gender_id' => $row['gender_id'],
                'birthDate' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthDate']),
                'jobTitle' => $row['jobTitle'],
                'email' => $row['email'],
            ]);

            StakeholderPerson::create([
                'person_id' => $person->id,
                'stakeholder_id' => $this->stakeholders[$row['company']],
                'admissionDate' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['admissionDate']),
                'cardNo' => $row['cardNo'],
            ]);
        }
    }

    /* public function model(array $row)
    {
        return new Person([
            'uid' => $row['uid'],
            'firstName' => $row['firstName'],
            'lastName' => $row['lastName'],
            'fullName' => $row['fullName'],
            'gender_id' => $row['gender_id'],
            'birthDate' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthDate']),
            'jobTitle' => $row['jobTitle'],
            'email' => $row['email'],
        ]);
    }
 */
    public function rules(): array
    {
        return [
            '*.uid'=> ['required','string'],
            '*.firstName'=> ['string'],
            '*.lastName'=> ['string'],
            '*.fullName'=> ['string'],
            '*.gender_id'=> ['numeric'],
            '*.birthDate'=> ['required'],
            '*.jobTitle'=> ['nullable'],
            '*.email'=> ['string'],
            '*.company'=> ['required'],
            '*.admissionDate'=> ['required'],
            '*.cardNo'=> ['required'],
        ];
    }
}
