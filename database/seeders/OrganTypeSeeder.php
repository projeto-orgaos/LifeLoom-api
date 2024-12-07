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
                'description' => 'Órgão vital necessário para circulação sanguínea.',
                'default_expiration_days' => 4,
                'default_distance_limit' => 500,
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'O+', 'O-'],
                    'age_range' => [18, 60]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Rim',
                'description' => 'Órgão responsável pela filtração do sangue.',
                'default_expiration_days' => 48,
                'default_distance_limit' => 1000,
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
                    'age_range' => [18, 70]
                ],
                'is_post_mortem' => false,
            ],
            [
                'name' => 'Fígado',
                'description' => 'Órgão essencial para a desintoxicação do organismo.',
                'default_expiration_days' => 8,
                'default_distance_limit' => 800,
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'B+', 'O+'],
                    'age_range' => [18, 65]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Pulmão',
                'description' => 'Órgão vital para a respiração e troca gasosa.',
                'default_expiration_days' => 6,
                'default_distance_limit' => 600,
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'O+', 'O-'],
                    'age_range' => [18, 50]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Pâncreas',
                'description' => 'Órgão que regula os níveis de açúcar no sangue.',
                'default_expiration_days' => 12,
                'default_distance_limit' => 700,
                'compatibility_criteria' => [
                    'blood_type' => ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'],
                    'age_range' => [18, 65]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Córnea',
                'description' => 'Tecido transparente que cobre o olho e auxilia na visão.',
                'default_expiration_days' => 14,
                'default_distance_limit' => 100,
                'compatibility_criteria' => [
                    'age_range' => [0, 75]
                ],
                'is_post_mortem' => true,
            ],
            [
                'name' => 'Medula Óssea',
                'description' => 'Tecido responsável pela produção de células sanguíneas.',
                'default_expiration_days' => 0, // Doação feita em vida, sem validade.
                'default_distance_limit' => 0, // Não aplicável para medula óssea.
                'compatibility_criteria' => [
                    'hla_compatibility' => true
                ],
                'is_post_mortem' => false,
            ],
        ];

        foreach ($organTypes as $type) {
            OrganType::create([
                'name' => $type['name'],
                'description' => $type['description'],
                'default_expiration_days' => $type['default_expiration_days'],
                'default_distance_limit' => $type['default_distance_limit'],
                'compatibility_criteria' => $type['compatibility_criteria'],
                'is_post_mortem' => $type['is_post_mortem'],
            ]);
        }
    }
}
