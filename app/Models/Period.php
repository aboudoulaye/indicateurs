<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    /** @use HasFactory<\Database\Factories\PeriodFactory> */
    use HasFactory;

    protected $guarded = [];

    public function records():HasMany
    {
        return $this->hasMany(Record::class);
    }
}
