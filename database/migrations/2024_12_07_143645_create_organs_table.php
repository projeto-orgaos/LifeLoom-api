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
        Schema::create('organs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organ_type_id')->constrained('organ_types')->onDelete('cascade')->comment('Tipo do órgão');
            $table->enum('status', ['Available', 'Donated', 'In Use', 'Expired'])->default('Available')->comment('Estado do órgão');
            $table->date('expiration_date')->comment('Data de validade do órgão');
            $table->integer('distance_limit')->nullable()->comment('Distância máxima de transporte do órgão (km)');
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals')->onDelete('set null')->comment('Hospital associado');
            $table->foreignId('donor_id')->nullable()->constrained('users')->onDelete('set null')->comment('Doador do órgão');
            $table->foreignId('recipient_id')->nullable()->constrained('users')->onDelete('set null')->comment('Receptor do órgão');
            $table->timestamp('matched_at')->nullable()->comment('Data de compatibilidade encontrada');
            $table->timestamp('completed_at')->nullable()->comment('Data de finalização (recepção do órgão)');
            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organs');
    }
};
