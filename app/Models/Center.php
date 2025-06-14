<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Center extends Model
{
    /** @use HasFactory<\Database\Factories\CenterFactory> */
    use HasFactory;

    protected $guarded = [];

    public function district():BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function programs():BelongsToMany
    {
        return $this->belongsToMany(Program::class,'center_programs','center_id','program_id');
    }

    public function products():BelongsToMany
    {
        return $this->BelongsToMany(Product::class,'center_products','center_id','product_id');
    }

    public function records():HasMany
    {
        return $this->hasMany(Record::class);
    }

    public function centertype()
    {
        return $this->belongsTo(CenterType::class);
    }
}
