<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kua extends Model
{
    protected $table = 'kuas';
    
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'operating_hours',
        'google_maps_link',
        'google_maps_embed',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Scope untuk hanya mengambil KUA yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk mengurutkan berdasarkan order
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
