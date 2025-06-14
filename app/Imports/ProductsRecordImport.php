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

    public function __construct()
    {
        $this->normalizedCenters = Center::all()->mapWithKeys(function ($center) {
            return [$this->normalize($center->name) => $center];
        });

        $this->normalizedProducts = Product::all()->mapWithKeys(function ($product) {
            return [$this->normalize($product->name) => $product];
        });
    }

    private function normalize($string)
    {
        $string = preg_replace('/[\x00-\x1F\x7F]/u', '', $string);
        $string = mb_strtolower($string, 'UTF-8');
        $converted = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        if ($converted === false) {
            $converted = $string;
        }
        $converted = preg_replace('/[^a-z0-9]/', '', $converted);
        return $converted;
    }

    public function model(array $row)
    {
        $period = Period::latest('period')->first();
        if (!$period) {
            return null;
        }

        // 1. Centre
        $centerName = trim($row[0]);
        $normalizedCenter = $this->normalize($centerName);
        $center = $this->normalizedCenters[$normalizedCenter] ?? null;
        if (!$center) {
            return null;
        }

        // 2. Produit
        $productName = trim($row[1]);
        $normalizedProduct = $this->normalize($productName);
        $product = $this->normalizedProducts[$normalizedProduct] ?? null;
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
