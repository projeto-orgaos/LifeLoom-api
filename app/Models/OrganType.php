<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',                              // Nome do tipo de órgão
        'description',                       // Descrição do tipo de órgão
        'default_preservation_time_minutes', // Tempo padrão de preservação em minutos
        'compatibility_criteria',            // Critérios de compatibilidade (JSON)
        'is_post_mortem',                    // Indica se é apenas post-mortem
    ];

    /**
     * Decodifica os critérios de compatibilidade armazenados em JSON.
     *
     * @param string|null $value
     * @return array|null
     */
    public function getCompatibilityCriteriaAttribute($value): ?array
    {
        return !empty($value) ? json_decode($value, true) : null;
    }

    /**
     * Codifica os critérios de compatibilidade ao salvar.
     *
     * @param array|null $value
     */
    public function setCompatibilityCriteriaAttribute($value): void
    {
        $this->attributes['compatibility_criteria'] = $value ? json_encode($value, JSON_THROW_ON_ERROR) : null;
    }

    /**
     * Relação com os órgãos baseados neste tipo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organs()
    {
        return $this->hasMany(Organ::class, 'organ_type_id');
    }
}
