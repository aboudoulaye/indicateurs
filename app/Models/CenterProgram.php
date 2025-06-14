<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class CenterProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id',
        'program_id',
        // ... other fillable attributes
    ];

    /**
     * Get the center that owns the CenterProgram.
     */
    public function center(): BelongsTo // Explicitly type-hint the return type
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    /**
     * Get the program that the CenterProgram belongs to.
     */
    public function program(): BelongsTo // Explicitly type-hint the return type
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}