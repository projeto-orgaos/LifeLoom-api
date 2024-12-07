<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'default_expiration_days',
        'default_distance_limit',
        'compatibility_criteria',
        'is_post_mortem',
    ];

    /**
     * Decodifica os critérios de compatibilidade armazenados em JSON.
     */
    public function getCompatibilityCriteriaAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Codifica os critérios de compatibilidade ao salvar.
     */
    public function setCompatibilityCriteriaAttribute($value)
    {
        $this->attributes['compatibility_criteria'] = json_encode($value);
    }

    /**
     * Relação com os órgãos baseados neste tipo.
     */
    public function organs()
    {
        return $this->hasMany(Organ::class, 'organ_type_id');
    }
}
