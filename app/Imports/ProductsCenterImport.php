<?php

namespace App\Imports;

use App\Models\Center;
use App\Models\Product;
use App\Models\CenterProduct;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsCenterImport implements ToModel
{
    private $count = 0;

    /**
    * @param array $row
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Sauter la première ligne (en-tête)
        if ($this->count++ === 0) {
            return null;
        }

        // Récupérer le nom de l'établissement et du produit
        $centerName = trim($row[0]);
        $productName = trim($row[1]);

        // Retrouver les IDs en base
        $center = Center::where('name', $centerName)->first();
        $product = Product::where('name', $productName)->first();

        // Si l'un des deux n'existe pas, on ignore la ligne
        if (!$center || !$product) {
            return null;
        }

        // Vérifier si la liaison existe déjà
        $exists = CenterProduct::where([
            'center_id' => $center->id,
            'product_id' => $product->id,
        ])->exists();

        if (!$exists) {
            return new CenterProduct([
                'center_id' => $center->id,
                'product_id' => $product->id,
            ]);
        }

        return null;
    }
}
