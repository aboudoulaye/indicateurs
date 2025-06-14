<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Record extends Model
{
    /** @use HasFactory<\Database\Factories\RecordFactory> */
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_records','product_id','record_id');
    }

    public function period():BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function center():BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
