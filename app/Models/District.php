<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    /** @use HasFactory<\Database\Factories\DistrictFactory> */
    use HasFactory;

    protected $guarded = [];

    public function Region():BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function centers():HasMany
    {
        return $this->hasMany(Center::class);
    }
}
