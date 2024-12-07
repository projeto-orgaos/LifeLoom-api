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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nome completo do usuário');
            $table->string('email')->unique()->comment('Endereço de e-mail do usuário');
            $table->string('cpf', 11)->unique()->comment('CPF do usuário');
            $table->date('birth_date')->comment('Data de nascimento do usuário');
            $table->enum('gender', ['male', 'female', 'other'])->comment('Gênero do usuário');
            $table->string('mother_name')->comment('Nome da mãe do usuário');
            $table->text('previous_diseases')->nullable()->comment('Doenças prévias do usuário');
            $table->timestamp('email_verified_at')->nullable()->comment('Data de verificação do e-mail');
            $table->string('password')->comment('Senha criptografada do usuário');
            $table->foreignId('profile_id')->constrained('profiles')->comment('ID do perfil do usuário');
            $table->string('phone')->comment('Número de telefone do usuário');
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->comment('Tipo sanguíneo do usuário');
            $table->foreignId('address_id')->constrained('addresses')->comment('ID do endereço do usuário');
            $table->rememberToken()->comment('Token para lembrar a autenticação');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary()->comment('E-mail do usuário');
            $table->string('token')->comment('Token de redefinição de senha');
            $table->timestamp('created_at')->nullable()->comment('Data de criação do token');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
    }
};
