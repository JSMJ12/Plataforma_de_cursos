<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    // Especifica la tabla asociada al modelo (opcional si la tabla sigue la convención plural del nombre del modelo)
    protected $table = 'cursos';

    // Especifica los atributos que se pueden asignar en masa
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
        'finalizado'
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
}
