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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id'); // Campo para el ID del usuario
            $table->enum('tipo_participante', ['Estudiantes de pregrado', 'Estudiantes de posgrado', 'Profesional', 'Otros']);
            $table->boolean('aprobado')->default(false);
            // Definir la clave foránea para el ID del usuario
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
