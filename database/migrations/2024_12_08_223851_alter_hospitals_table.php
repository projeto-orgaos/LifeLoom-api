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
        Schema::table('hospitals', function (Blueprint $table) {
            // Adiciona a coluna para o nome do responsável pelo hospital
            $table->string('responsible')->nullable()->comment('Responsável pelo hospital');

            // Adiciona a coluna para o CNPJ do hospital
            $table->string('cnpj')->nullable()->unique()->comment('CNPJ do hospital');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            // Remove as colunas adicionadas
            $table->dropColumn('responsible');
            $table->dropColumn('cnpj');
        });
    }
};
