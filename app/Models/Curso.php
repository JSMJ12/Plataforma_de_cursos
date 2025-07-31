<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'precio',
        'horas_academicas',
        'tipo',
        'nombre_maestria',
        'image',
        'capacitador_id',
        'finalizado',
        'tipo_curso',
        'coordinador_maestria',
    ];

    // Especifica los atributos que deben ser tratados como fechas
    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];
    public function itinerarios()
    {
        return $this->hasMany(Itinerario::class);
    }
    public function capacitador()
    {
        return $this->belongsTo(User::class, 'capacitador_id');
    }
    public function registros()
    {
        return $this->hasMany(Registro::class);
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
