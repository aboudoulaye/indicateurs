<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    private $current = 0;

    public function model(array $row)
    {
        if ($this->current++ == 0) {
            return null;
        }


        $existingProduct = Product::where('code', $row[0])->first();

        if ($existingProduct) {
            return null;
        }

        
        return new Product([
            'code' => $row[0],
            'name' => $row[1],
            'tracer' => $row[2],
        ]);

        return null;
    }
}
