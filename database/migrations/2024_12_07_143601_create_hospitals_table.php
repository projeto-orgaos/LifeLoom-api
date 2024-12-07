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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nome do hospital');
            $table->string('registration_number')->nullable()->unique()->comment('Número de registro do hospital');
            // ART do hospital, CNPJ
            $table->string('cnpj')->nullable()->unique()->comment('CNPJ do hospital');
            $table->string('responsible')->nullable()->comment('Responsável pelo hospital');
            $table->string('phone')->nullable()->comment('Telefone');
            $table->string('email')->nullable()->unique()->comment('Email do hospital');
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade')->comment('Endereço do hospital');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
