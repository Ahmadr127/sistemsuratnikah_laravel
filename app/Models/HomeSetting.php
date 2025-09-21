<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'features',
        'stats',
    ];

    protected $casts = [
        'features' => 'array',
        'stats' => 'array',
    ];
}


