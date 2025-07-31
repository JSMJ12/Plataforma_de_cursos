<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre'); // Nombre de la empresa
            $table->string('direccion')->nullable(); // Dirección de la empresa
            $table->string('telefono')->nullable(); // Teléfono de contacto
            $table->string('email')->unique(); // Email de contacto
            $table->string('sitio_web')->nullable(); // Sitio web
            $table->string('logo')->nullable(); // Campo para almacenar el logo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
