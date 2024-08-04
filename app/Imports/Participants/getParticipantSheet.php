<?php

namespace App\Imports\Participants;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GetParticipantSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // First sheet
        $sheets[] = new \App\Imports\Participants\Sheet1Import();

        return $sheets;
    }
}
