<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = [];

    public function centers():BelongsToMany
    {
        return $this->BelongsToMany(Center::class,'center_products','center_id','product_id');
    }

    public function specials():BelongsToMany
    {
        return $this->belongsToMany(Special::class,'product_specials','product_id','special_id');
    }

    public function programs():BelongsToMany
    {
        return $this->BelongsToMany(Program::class,'product_programs','product_id','program_id');
    }

    public function records()
    {
        return $this->belongsToMany(Record::class,'product_record');
    }
}
