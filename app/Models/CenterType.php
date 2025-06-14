<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterType extends Model
{
    /** @use HasFactory<\Database\Factories\CenterTypeFactory> */
    use HasFactory;

    protected $guarded=[];

    public function centers(){
        return $this->hasMany(Center::class);
    }
}
