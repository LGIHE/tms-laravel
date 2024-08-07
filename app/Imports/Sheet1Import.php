<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\requiredInUpload;
use App\Models\Trainee;

class Sheet1Import implements ToCollection, WithHeadingRow
{

    /**
    * @param array $row
    *
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.name' => new requiredInUpload('name'),
            '*.gender' => new requiredInUpload('gender'),
            '*.category' => new requiredInUpload('category'),
        ])->validate();

        $trainees = [];

        foreach ($rows as $row) {
            $trainee = Trainee::create([
                'training' => request()->training,
                'name' => $row['name'],
                'gender' => $row['gender'],
                'age' => $row['age'],
                'category' => $row['category'],
                'nationality' => $row['nationality'],
                'district' => $row['district'],
                'village' => $row['village'],
                'days_attended' => $row['days_attended'],
                'institution' => $row['institution'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'created_by' => auth()->user()->id,
            ]);

            $trainees[] = $trainee;
        }

        return $trainees;
    }


}
