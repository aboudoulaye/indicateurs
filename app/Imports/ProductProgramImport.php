<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductProgram;
use App\Models\Program;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductProgramImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $current=0;

    public function model(array $row)
    {
        if($this->current++ === 0)
        {
            return null;
        }

        $program = Program::where('code',$row[0])->first();
        if (!$program) {
            return null;
        }

        $product = Product::where('code',$row[2])->first();
        if (!$product) {
            return null;
        }

        $existingProductProgram = ProductProgram::where('product_id',$product->id)
                                ->where('program_id',$program->id)->exists();
        if ($existingProductProgram) {
            return null;
        }

        return new ProductProgram([
            'program_id'=>$program->id,
            'product_id'=>$product->id,
        ]);

        return null;
    }
}
