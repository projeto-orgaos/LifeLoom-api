<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('organ_types', function (Blueprint $table) {
            // Verifica e remove a coluna 'default_expiration_days' se ela existir
            if (Schema::hasColumn('organ_types', 'default_expiration_days')) {
                $table->dropColumn('default_expiration_days');
            }

            // Adiciona a nova coluna 'default_preservation_time_minutes'
            if (!Schema::hasColumn('organ_types', 'default_preservation_time_minutes')) {
                $table->integer('default_preservation_time_minutes')->nullable()->default(240)->comment('Tempo padrão de preservação em minutos');
            }

            // Verifica e remove a coluna 'default_distance_limit' se ela existir
            if (Schema::hasColumn('organ_types', 'default_distance_limit')) {
                $table->dropColumn('default_distance_limit');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organ_types', function (Blueprint $table) {
            // Remove a coluna 'default_preservation_time_minutes' se ela existir
            if (Schema::hasColumn('organ_types', 'default_preservation_time_minutes')) {
                $table->dropColumn('default_preservation_time_minutes');
            }

            // Adiciona novamente a coluna 'default_expiration_days' se ela não existir
            if (!Schema::hasColumn('organ_types', 'default_expiration_days')) {
                $table->integer('default_expiration_days')->comment('Validade padrão do órgão em dias');
            }

            // Adiciona novamente a coluna 'default_distance_limit' se ela não existir
            if (!Schema::hasColumn('organ_types', 'default_distance_limit')) {
                $table->integer('default_distance_limit')->comment('Distância máxima padrão para transporte do órgão (km)');
            }
        });
    }
};
