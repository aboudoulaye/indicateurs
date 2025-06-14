<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecord extends Model
{
    /** @use HasFactory<\Database\Factories\ProductRecordFactory> */
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function record()
    {
        return $this->belongsTo(Record::class);
    }
}
