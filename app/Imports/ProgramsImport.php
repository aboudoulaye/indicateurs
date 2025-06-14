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

        $programCode = trim($row[0]);
        $programName = trim($row[1]);
        // Trim the region name and check for empty values

        if (empty($programName) || empty($programCode)) {
            return null; // Ignore les lignes incomplètes
        }

        $existingProgram = Program::whereRaw('LOWER(name) = ?', [strtolower($programName)])
            ->orWhere('code', $programCode)
            ->first();

        // Create region only if it doesn't exist
        if (!$existingProgram) {
            return new Program([
                'code' => $programCode,
                'name' => $programName,
            ]);
        }

        return null;
    }
}
