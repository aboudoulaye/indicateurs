<?php

namespace App\Imports;

use App\Models\Center;
use App\Models\CenterProgram;
use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;

class ProgramsCenterImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    private $count = 0;


    public function model(array $row)
    {

        // Skip header row
        if ($this->count++ === 0) {
            return null;
        }

        // Find program and établissement by name
        $program = Program::where('code', trim($row[0]))->first();
        $center = Center::where('code', trim($row[2]))->first();

        // Check if relation already exists
        $existingRelation = CenterProgram::where([
            'program_id' => $program?->id,
            'Center_id' => $center?->id
        ])->exists();

        // Create new relation if it doesn't exist
        if ($program && $center && !$existingRelation) {
            return new CenterProgram([
                'program_id' => $program->id,
                'center_id' => $center->id
            ]);
        }

        return null;
    }
}
