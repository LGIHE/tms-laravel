<?php

namespace App\Imports\Participants;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\requiredInParticipantUpload;
use App\Models\Participants;

class Sheet1Import implements ToCollection, WithHeadingRow
{

    /**
    * @param array $row
    *
    */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.id_no' => new requiredInParticipantUpload('id_no'),
            '*.name' => new requiredInParticipantUpload('name'),
            '*.gender' => new requiredInParticipantUpload('gender'),
            '*.age' => new requiredInParticipantUpload('age'),
            '*.category' => new requiredInParticipantUpload('category'),
            '*.phone' => new requiredInParticipantUpload('phone'),
            '*.address' => new requiredInParticipantUpload('address'),
        ])->validate();

        $participants = [];

        foreach ($rows as $row) {
            $participant = Participants::create([
                'id_no' => $row['id_no'],
                'name' => $row['name'],
                'gender' => $row['gender'],
                'age' => $row['age'],
                'category' => $row['category'],
                'nationality' => $row['nationality'],
                'institution' => $row['institution'],
                'email' => $row['email'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'created_by' => auth()->user()->id,
            ]);

            $participants[] = $participant;
        }

        return $participants;
    }


}
