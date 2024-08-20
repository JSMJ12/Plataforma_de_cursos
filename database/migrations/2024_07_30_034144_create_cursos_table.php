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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // Campo 'id' como clave primaria auto-incremental
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('horas_academicas');
            $table->enum('tipo', ['Maestría', 'Instituto']);
            $table->string('nombre_maestria')->nullable(); // Campo para el nombre de la maestría en caso de ser tipo "Maestría"
            $table->string('image')->nullable();
            $table->string('tipo_curso')->nullable();
            $table->string('coordinador_maestria')->nullable();
            $table->unsignedBigInteger('capacitador_id');
            $table->boolean('finalizado')->default(false); // Campo para controlar si el curso está activo o no
            $table->foreign('capacitador_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
