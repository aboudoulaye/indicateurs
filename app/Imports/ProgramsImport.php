<?php

namespace App\Imports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgramsImport implements ToModel
{
    /**
     * @param Collection $collection
     */

    private $current = 0;

    public function model(array $row)
    {
        if ($this->current++ <= 1) {
            return null;
        }

        $existingProgram = Program::Where('code', $row[0])->first();

        // Create region only if it doesn't exist
        if (!$existingProgram) {
            return new Program([
                'code' => $row[0],
                'name' => $row[1],
            ]);
        }

        return null;
    }
}
