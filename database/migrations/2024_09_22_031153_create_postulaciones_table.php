<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulacionesTable extends Migration
{
    public function up()
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajo_id')->constrained('trabajos')->onDelete('cascade'); // Relación con trabajo
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con usuario (graduado)
            $table->string('estado')->default('pendiente'); // Estado de la postulación (pendiente, aceptado, rechazado)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('postulaciones');
    }
}
