<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'cnpj',
        'responsible',
        'phone',
        'email',
        'address_id',
    ];

    /**
     * Relação com Address.
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Relação com usuários associados ao hospital.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'hospital_users')->withPivot('role')->withTimestamps();
    }

    /**
     * Relação com órgãos associados ao hospital.
     */
    public function organs()
    {
        return $this->hasMany(Organ::class);
    }

    /**
     * Relação com UserOrgans para rastrear os órgãos associados a doadores/receptores neste hospital.
     */
    public function userOrgans()
    {
        return $this->hasMany(UserOrgan::class);
    }
}
