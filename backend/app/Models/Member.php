<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'marital_status',
        'city',
        'address',
        'baptism_date',
        'baptism_place',
        'membership_date',
        'status',
        'ecclesiastical_role',
        'is_server',
        'category',
        'notes',
    ];

    // Unificación a 'phone' en API; se mantiene mutator para compatibilidad

    protected $casts = [
        'birth_date' => 'date',
        'baptism_date' => 'date',
        'membership_date' => 'date',
        'is_server' => 'boolean',
    ];

    /**
     * Relación muchos a muchos con Ministerios (áreas de servicio)
     */
    public function ministries(): BelongsToMany
    {
        return $this->belongsToMany(Ministry::class, 'member_ministry')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Relación uno a muchos con Transacciones
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Accessor para nombre completo
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Accessor para edad
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }
        return $this->birth_date->age;
    }

}
