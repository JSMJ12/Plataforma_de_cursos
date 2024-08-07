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
            $table->string('dni', 20)->unique(); 
            $table->string('name');
            $table->string('name2');
            $table->string('apellidop');
            $table->string('apellidom');
            $table->string('email')->unique();
            $table->string('ciudad')->nullable();
            $table->string('celular', 20);
            $table->string('nivel_estudio')->nullable();
            $table->string('login_token')->nullable()->unique();
            // Campos específicos para Capacitadores
            $table->string('titulo')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('image')->nullable();
            $table->integer('anos_experiencia')->nullable();
            $table->integer('edad')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('sexo', 1)->nullable();
            $table->boolean('aprovado')->default(false);
            $table->boolean('permiso_curso')->default(false);
            // Campos específicos para Participantes
            $table->string('interes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
