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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street')->comment('Rua');
            $table->string('number')->nullable()->comment('Número');
            $table->string('complement')->nullable()->comment('Complemento');
            $table->string('neighborhood')->comment('Bairro');
            $table->string('city')->comment('Cidade');
            $table->char('state', 2)->comment('Estado');
            $table->string('zip_code')->comment('CEP');
            $table->softDeletes();
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
