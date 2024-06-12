<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GetTraineeSheet implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // First sheet
        $sheets[] = new \App\Imports\Sheet1Import();

        return $sheets;
    }
}
