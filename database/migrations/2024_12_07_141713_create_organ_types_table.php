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
        Schema::create('organ_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nome do tipo de órgão');
            $table->text('description')->nullable()->comment('Descrição do tipo de órgão');
            $table->integer('default_expiration_days')->comment('Validade padrão do órgão em dias');
            $table->integer('default_distance_limit')->comment('Distância máxima padrão para transporte do órgão (km)');
            $table->json('compatibility_criteria')->nullable()->comment('Critérios de compatibilidade em formato JSON');
            $table->boolean('is_post_mortem')->default(false)->comment('Indica se o órgão só pode ser doado post-mortem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organ_types');
    }
};
