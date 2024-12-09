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
        Schema::table('organs', function (Blueprint $table) {
            // Adicionar novos estados ao campo `status`
            $table->enum('status', ['Available', 'Donated', 'In Use', 'Expired', 'Pending', 'Waiting'])->default('Available')->change()->comment('Estado do órgão, incluindo estados de espera');

            // Alterar o tipo de `expiration_date` para timestamp
            $table->timestamp('expiration_date')->nullable()->change();

            // Remover a coluna `distance_limit`
            if (Schema::hasColumn('organs', 'distance_limit')) {
                $table->dropColumn('distance_limit');
            }

            // Adicionar índice para otimização da busca por status
            $table->index('status', 'idx_organs_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organs', function (Blueprint $table) {
            // Reverter a alteração no campo `status`
            $table->enum('status', ['Available', 'Donated', 'In Use', 'Expired'])->default('Available')->change();

            // Reverter o tipo de `expiration_date` para date
            $table->date('expiration_date')->nullable()->change();

            // Restaurar a coluna `distance_limit`
            $table->integer('distance_limit')->nullable()->comment('Distância máxima de transporte do órgão (km)');

            // Remover o índice
            $table->dropIndex('sus');
        });
    }
};
