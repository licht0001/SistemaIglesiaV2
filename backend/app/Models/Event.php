<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'location',
        'type',
        'is_public',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_public' => 'boolean',
    ];

    /**
     * Scope para eventos programados
     */
    public function scopeProgramados($query)
    {
        return $query->where('status', 'programado');
    }

    /**
     * Scope para eventos públicos
     */
    public function scopePublicos($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope para eventos próximos
     */
    public function scopeProximos($query)
    {
        return $query->where('start_at', '>=', now())
            ->where('status', 'programado');
    }
}
