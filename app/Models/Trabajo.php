<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = ['titulo', 'descripcion', 'requisitos', 'salario', 'empresa_id', 'tipo_contrato', 'ubicacion', 'fecha_publicacion', 'fecha_limite'];

    // Relación con la empresa (Un trabajo pertenece a una empresa)
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Relación con postulaciones (Un trabajo tiene muchas postulaciones)
    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'trabajo_id');
    }
}

