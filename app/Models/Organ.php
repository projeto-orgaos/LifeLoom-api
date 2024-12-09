<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Organ extends Model
{
    use HasFactory;

    protected $fillable = [
        'organ_type_id',
        'status',
        'expiration_date',
        'hospital_id',
        'donor_id',
        'recipient_id',
        'matched_at',
        'completed_at',
    ];

    protected $casts = [
        'expiration_date' => 'datetime',
        'matched_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relationship: Organ Type
     * Relaciona o órgão ao seu tipo.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(OrganType::class, 'organ_type_id');
    }

    /**
     * Relationship: Hospital
     * Relaciona o órgão ao hospital associado.
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Relationship: Donor
     * Relaciona o órgão ao doador.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    /**
     * Relationship: Recipient
     * Relaciona o órgão ao receptor.
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Escopo para órgãos disponíveis.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'Available')
            ->whereDate('expiration_date', '>=', now());
    }

    /**
     * Escopo para órgãos pendentes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'Pending');
    }

    /**
     * Verifica se o órgão está disponível.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->status === 'Available' && $this->expiration_date >= now();
    }

    /**
     * Verifica se o órgão está expirado.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expiration_date < now();
    }

    /**
     * Escopo para órgãos expirados.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereDate('expiration_date', '<', now());
    }

    /**
     * Escopo para órgãos em uso.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInUse(Builder $query): Builder
    {
        return $query->where('status', 'In Use');
    }

    /**
     * Escopo para órgãos doados.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeDonated(Builder $query): Builder
    {
        return $query->where('status', 'Donated');
    }
}
