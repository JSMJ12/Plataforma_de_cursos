<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosTable extends Migration
{
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade'); // Relación con la empresa
            $table->string('titulo'); // Título del trabajo
            $table->text('descripcion'); // Descripción del trabajo
            $table->string('ubicacion'); // Ubicación del trabajo
            $table->string('tipo_contrato'); // Tipo de contrato (temporal, fijo, etc.)
            $table->decimal('salario', 10, 2)->nullable(); // Salario del puesto
            $table->date('fecha_publicacion'); // Fecha de publicación
            $table->date('fecha_limite');
            $table->text('requisitos');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trabajos');
    }
}
