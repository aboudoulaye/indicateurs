<?php

namespace App\Imports;

use App\Models\Center;
use App\Models\Period;
use App\Models\Product;
use App\Models\ProductRecord;
use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsRecordImport implements ToModel
{
    private $normalizedCenters = [];
    private $normalizedProducts = [];

    public function model(array $row)
    {
        $period = Period::latest('period')->first();
        if (!$period) {
            return null;
        }

        // 1. Centre
        $center = Center::where('code',$row[5])->first();
        if (!$center) {
            return null;
        }

        // 2. Produit
        $product = Product::where('code',$row[9])->first();
        if (!$product) {
            return null;
        }

        // 3. Record
        $record = Record::where('period_id', $period->id)
            ->where('center_id', $center->id)
            ->first();
            
        if (!$record) {
            return null;
        }

        // 4. Création ProductRecord
        return new ProductRecord([
            'product_id'        => $product->id,
            'record_id'         => $record->id,
            'stock_initial'     => $row[2],
            'qte_recu'          => $row[3],
            'qte_distribuée'    => $row[4],
            'perte_ajustement'  => $row[5],
            'sdu'               => $row[6],
            'cmm'               => $row[7],
            'nbr_jrs'           => $row[8],
            'qte_proposee'      => $row[9],
            'qte_cmde'          => $row[10],
            'qte_approuve'      => $row[11],
            'explication'       => $row[12],
        ]);
    }
}
