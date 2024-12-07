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
        Schema::create('user_organs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Usuário associado');
            $table->foreignId('organ_id')->constrained('organs')->onDelete('cascade')->comment('Órgão associado');
            $table->enum('type', ['Doador', 'Receptor'])->comment('Tipo de vínculo');
            $table->enum('status', ['Pending', 'Matched', 'Completed'])->default('Pending')->comment('Status da relação');
            $table->timestamp('matched_at')->nullable()->comment('Data de associação');
            $table->timestamp('completed_at')->nullable()->comment('Data de conclusão');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_organs');
    }
};
