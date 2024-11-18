<?php

namespace App\Imports\Participants;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use App\Rules\RequiredInParticipantUpload;
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

        $participants = [];

        foreach ($rows as $rowNumber => $row) {
            $rowNumber++;

            Validator::make($row->toArray(), [
                'id_no' => [
                    new RequiredInParticipantUpload('id_no', $rowNumber),
                    new UniqueParticipantIdForTraining(request()->training_id, 'id_no'),
                ],
                'name' => new RequiredInParticipantUpload('name', $rowNumber),
                'gender' => new RequiredInParticipantUpload('gender', $rowNumber),
                'age' => new RequiredInParticipantUpload('age', $rowNumber),
                'category' => new RequiredInParticipantUpload('category', $rowNumber),
                'nationality' => new RequiredInParticipantUpload('nationality', $rowNumber),
                'phone' => new RequiredInParticipantUpload('phone', $rowNumber),
                'district' => new RequiredInParticipantUpload('district', $rowNumber),
                'dates_attended' => new RequiredInParticipantUpload('dates_attended', $rowNumber),
            ])->validate();

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
