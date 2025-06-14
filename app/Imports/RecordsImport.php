<?php

namespace App\Imports;

use App\Models\Center;
use App\Models\Period;
use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;

class RecordsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $current = 0;

    
    public function model(array $row)
    {
    
        $lastPeriod = Period::latest('id')->first();
        if (!$lastPeriod) {
            return null;
        }
        $periodId = $lastPeriod->id;

        // Récupérer le centre par son nom (ou autre champ unique)
        $center = Center::where('name', $row['0'])->first();

        if (!$center) {
            // Centre non trouvé, on ignore ou on peut loguer l’erreur
            return null;
        }

        $centerId = $center->id;

        // Vérifier si le record existe déjà
        $exists = Record::where('period_id', $periodId)
                        ->where('center_id', $centerId)
                        ->exists();

        if ($exists) {
            return null; // Ignorer si déjà existant
        }

        return new Record([
            'period_id' => $periodId,
            'center_id' => $centerId,
        ]);
    }
    
}
