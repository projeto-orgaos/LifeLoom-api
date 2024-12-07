<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    use HasFactory;

    protected $fillable = [
        'organ_type_id',
        'status',
        'expiration_date',
        'distance_limit',
        'hospital_id',
        'donor_id',
        'recipient_id',
        'matched_at',
        'completed_at',
    ];

    /**
     * Tipo de órgão base.
     */
    public function type()
    {
        return $this->belongsTo(OrganType::class, 'organ_type_id');
    }

    /**
     * Hospital onde o órgão está localizado.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    /**
     * Usuário doador do órgão.
     */
    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    /**
     * Usuário receptor do órgão.
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Escopo para órgãos disponíveis.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'Available')
            ->whereDate('expiration_date', '>=', now());
    }

    /**
     * Verifica se o órgão está disponível.
     */
    public function isAvailable()
    {
        return $this->status === 'Available' && $this->expiration_date >= now();
    }

    /**
     * Verifica se o órgão está expirado.
     */
    public function isExpired()
    {
        return $this->expiration_date < now();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }
}
