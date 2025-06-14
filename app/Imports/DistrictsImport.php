<?php

namespace App\Imports;

use App\Models\District;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;

class DistrictsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $current = 0;

    public function model(array $row)
    {

        if ($this->current++ < 1) {
            return;
        }

        $region = Region::where('name', $row[1])->first();

        $district = District::where('name', $row[0])->first();

        if ($district) {
            return;
        }

        if ($this->current++ > 1) {

            if ($region) {
                return new District([
                    'name' => $row[0],
                    'region_id' => $region->id
                ]);
            }

            return null;
        }
    }
}
