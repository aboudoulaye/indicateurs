<?php

namespace App\Exports;

use App\Models\ProductRecord;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsREcordExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductRecord::all();
    }
}
