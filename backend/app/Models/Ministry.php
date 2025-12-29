<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ministry extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relación muchos a muchos con Miembros
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_ministry')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Scope para ministerios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar por orden
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('order');
    }
}
