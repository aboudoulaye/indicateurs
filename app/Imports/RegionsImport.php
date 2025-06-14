<?php

namespace App\Imports;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;

class RegionsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $current=0;

    public function model(array $row)
    {
        if ($this->current++ == 0) {
            return null;
        }
    
        $regionName = trim($row[0]);
        if (empty($regionName)) {
            return null;
        }
    
        $existingRegion = Region::whereRaw('LOWER(name) = ?', [strtolower($regionName)])->first();
    
        if (!$existingRegion) {
            return new Region([
                'name' => $regionName
            ]);
        }
    
        return null;
    }
}
