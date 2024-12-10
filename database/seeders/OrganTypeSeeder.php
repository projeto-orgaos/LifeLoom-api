<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganType;

class OrganTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $organTypes = [
            [
                'name' => 'Coração',
                'description' => 'Órgão vital responsável pela circulação sanguínea.',
                'default_preservation_time_minutes' => 240, // 4 horas
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'O+', 'O-'],
                    'age_range' => [18, 60]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Pulmão',
                'description' => 'Órgão vital para respiração e troca gasosa.',
                'default_preservation_time_minutes' => 360, // 6 horas
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'O+', 'O-'],
                    'age_range' => [18, 50]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Fígado',
                'description' => 'Órgão essencial para a desintoxicação do organismo.',
                'default_preservation_time_minutes' => 720, // 12 horas
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'B+', 'O+'],
                    'age_range' => [18, 65]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Rim',
                'description' => 'Órgão responsável pela filtração do sangue.',
                'default_preservation_time_minutes' => 2880, // 48 horas
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
                    'age_range' => [18, 70]
                ],
                'is_post_mortem' => false,
            ],
            [
                'name' => 'Pâncreas',
                'description' => 'Órgão que regula os níveis de açúcar no sangue.',
                'default_preservation_time_minutes' => 720, // 12 horas
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
                    'age_range' => [18, 65]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Córnea',
                'description' => 'Tecido transparente que cobre o olho e auxilia na visão.',
                'default_preservation_time_minutes' => 20160, // 14 dias
                'compatibility_criteria' => [
                    'age_range' => [0, 75]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Medula Óssea',
                'description' => 'Tecido responsável pela produção de células sanguíneas.',
                'default_preservation_time_minutes' => 0, // Não aplicável para doação em vida
                'compatibility_criteria' => [
                    'hla_compatibility' => true
                ],
                'is_post_mortem' => false,
            ],
            [
                'name' => 'Pele',
                'description' => 'Tecido usado em enxertos e reconstruções.',
                'default_preservation_time_minutes' => 43200, // 30 dias
                'compatibility_criteria' => [
                    'age_range' => [0, 80]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Válvulas Cardíacas',
                'description' => 'Estruturas usadas em transplantes cardíacos.',
                'default_preservation_time_minutes' => 43200, // 30 dias
                'compatibility_criteria' => [
                    'age_range' => [0, 65]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Ossos',
                'description' => 'Tecido usado para reconstruções ortopédicas.',
                'default_preservation_time_minutes' => 43200, // 30 dias
                'compatibility_criteria' => [
                    'age_range' => [0, 70]
                ],
                'is_post_mortem' => true,
            ],
        ];

        foreach ($organTypes as $type) {
            OrganType::create($type);
        }
    }
}
