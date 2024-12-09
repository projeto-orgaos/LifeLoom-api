<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'birth_date',
        'gender',
        'mother_name',
        'previous_diseases',
        'password',
        'profile_id',
        'phone',
        'blood_type',
        'address_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Órgãos doados pelo usuário.
     *
     * @return HasMany
     */
    public function donatedOrgans(): HasMany
    {
        return $this->hasMany(Organ::class, 'donor_id');
    }

    /**
     * Órgãos recebidos pelo usuário.
     *
     * @return HasMany
     */
    public function receivedOrgans(): HasMany
    {
        return $this->hasMany(Organ::class, 'recipient_id');
    }



    public function allOrgans()
    {
        return Organ::where('donor_id', $this->id)
            ->orWhere('recipient_id', $this->id)
            ->with('type') // Carrega o tipo do órgão relacionado
            ->get();
    }
}
