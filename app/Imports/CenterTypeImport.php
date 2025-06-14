<?php

namespace App\Imports;

use App\Models\CenterType;
use Maatwebsite\Excel\Concerns\ToModel;

class CenterTypeImport implements ToModel
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
    
        $existingType = CenterType::where('name',$row[0])->first();

        if($existingType)
        {
            return null;
        }
    
            return new CenterType([
                'name' => $row[0]
            ]);
    
    }
}
