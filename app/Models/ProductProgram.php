<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProgram extends Model
{
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
