<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Special extends Model
{
    /** @use HasFactory<\Database\Factories\SpecialFactory> */
    use HasFactory;

    protected $guarded = [];

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_specials','special_id', 'product_id');
    }
}
