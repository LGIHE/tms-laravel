<?php

namespace App\Imports\Participants;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\requiredInParticipantUpload;
use App\Rules\UniqueParticipantIdForTraining;
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
            '*.id_no' => [
                new RequiredInParticipantUpload('id_no'),
                new UniqueParticipantIdForTraining(request()->training_id, 'id_no'),
            ],
            '*.name' => new requiredInParticipantUpload('name'),
            '*.gender' => new requiredInParticipantUpload('gender'),
            '*.age' => new requiredInParticipantUpload('age'),
            '*.category' => new requiredInParticipantUpload('category'),
            '*.nationality' => new requiredInParticipantUpload('nationality'),
            '*.phone' => new requiredInParticipantUpload('phone'),
            '*.district' => new requiredInParticipantUpload('district'),
            '*.dates_attended' => new requiredInParticipantUpload('dates_attended'),
        ])->validate();

        $participants = [];

        foreach ($rows as $row) {
            if (isset($row['subjects']) && $row['subjects'] != null) {
                // Split the subjects string by comma and trim any extra spaces
                $subjects = explode(',', $row['subjects']);
                $subjects = array_map('trim', $subjects); // Trim spaces around each subject
                $row['subjects'] = $subjects;
            } else {
                $row['subjects'] = [];
            }

            if (isset($row['dates_attended']) && $row['dates_attended'] != null) {
                // Split the dates string by comma and trim any extra spaces
                $dates_attended = explode(',', $row['dates_attended']);
                $dates_attended = array_map('trim', $dates_attended); // Trim spaces around each date
                $row['trainings'] = [
                    'training_id' => request()->training_id,
                    'dates' => $dates_attended,
                ];
            } else {
                $row['trainings'] = [];
            }

            $participant = Participants::create([
                'id_no' => $row['id_no'],
                'name' => $row['name'],
                'gender' => $row['gender'],
                'age' => $row['age'],
                'category' => $row['category'],
                'nationality' => $row['nationality'],
                'institution' => $row['institution'],
                'institution_ownership' => $row['institution_ownership'],
                'education_level' => $row['education_level'],
                'subjects' => json_encode($row['subjects']),
                'email' => $row['email'],
                'phone' => $row['phone'],
                'district' => $row['district'],
                'trainings' => json_encode([$row['trainings']]),
                'created_by' => auth()->user()->id,
            ]);

            $participants[] = $participant;
        }

        return $participants;
    }


}
