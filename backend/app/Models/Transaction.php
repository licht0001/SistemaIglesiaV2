<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'member_id',
        'type',
        'category',
        'sub_category',
        'amount',
        'transaction_date',
        'payment_method',
        'reference',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /**
     * Relación muchos a uno con Miembro
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope para filtrar ingresos
     */
    public function scopeIngresos($query)
    {
        return $query->where('type', 'ingreso');
    }

    /**
     * Scope para filtrar egresos
     */
    public function scopeEgresos($query)
    {
        return $query->where('type', 'egreso');
    }
}
