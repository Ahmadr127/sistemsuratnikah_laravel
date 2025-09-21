<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marriage extends Model
{
    protected $fillable = [
        'groom_nik',
        'groom_name',
        'groom_birth_date',
        'groom_birth_place',
        'groom_address',
        'bride_nik',
        'bride_name',
        'bride_birth_date',
        'bride_birth_place',
        'bride_address',
        'marriage_date',
        'marriage_place',
        'witness1_name',
        'witness2_name',
        'status',
        'created_by',
    ];

    protected $casts = [
        'marriage_date' => 'date',
        'groom_birth_date' => 'date',
        'bride_birth_date' => 'date',
    ];

    /**
     * Get the user who created this marriage record
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
