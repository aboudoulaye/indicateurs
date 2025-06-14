<?php

namespace App\Imports;

use App\Models\Center;
use App\Models\CenterType;
use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;

class CentersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $current = 0;

    public function model(array $row)
    {
        if ($this->current++ <= 1) {
            // Ignore la première ligne (souvent l'en-tête)
            return null;
        }

        // Recherche du district par nom
        $district = District::where('name', $row[3])->first();

        if (!$district) {
            return null;
        }

        // Recherche du center par nom
        $center = Center::where('name', $row[1])->first();
        if ($center) {
            // Center déjà existant, on ne fait rien
            return null;
        }

        $type = CenterType::where('name', $row[2])->first();
        if (!$type) {
            // Center déjà existant, on ne fait rien
            return null;
        }

        // Création du nouveau center
        return new Center([
            'code' => $row[0],
            'name' => $row[1],
            'district_id' => $district->id,
            'centertype_id' => $type->id,
        ]);
    }
}
