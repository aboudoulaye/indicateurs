<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;

    protected $guarded = [];

    public function centers():BelongsToMany
    {
        return $this->belongsToMany(Center::class,'center_programs','center_id','program_id');
    }

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_programs','product_id','program_id');
    }
}
