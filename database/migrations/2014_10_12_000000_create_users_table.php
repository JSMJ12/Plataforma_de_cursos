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
            //Campos Para Graduados
            // Campos personales graduados
            $table->string('programa_maestria')->nullable();
            $table->string('fecha_graduacion')->nullable();
            // Datos laborales
            $table->string('empleado_actualmente')->nullable();
            $table->string('nombre_empresa')->nullable();
            $table->string('cargo_actual')->nullable();
            $table->string('trabajo_vinculado')->nullable();
            $table->string('anos_experiencia_laboral')->nullable();
            $table->string('empleos_desde_graduacion')->nullable();
            $table->string('cv')->nullable();
            
            // Desarrollo profesional
            $table->string('estudios_adicionales')->nullable();
            $table->string('desarrollo_profesional_continuo')->nullable();
            
            // Evaluación del programa
            $table->string('pertinencia_formacion')->nullable();
            $table->integer('satisfaccion_programa')->nullable();
            $table->text('aspectos_utiles')->nullable();
            $table->text('aspectos_mejorables')->nullable();
            $table->string('actividades_investigacion')->nullable();
            $table->string('recomendar_programa')->nullable();
            
            // Capacitación continua
            $table->string('interes_capacitacion_continua')->nullable();
            $table->text('temas_interes')->nullable();
            
            // Competencias y habilidades
            $table->string('resolucion_de_problemas')->nullable();
            $table->string('comunicacion_oral')->nullable();
            $table->string('analisis')->nullable();
            $table->string('creatividad')->nullable();
            $table->string('trabajo_en_equipo')->nullable();

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
