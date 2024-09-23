<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = ['nombre', 'direccion', 'telefono', 'email', 'sitio_web', 'logo'];

    // Relación con los trabajos (Una empresa tiene muchos trabajos)
    public function trabajos()
    {
        return $this->hasMany(Trabajo::class);
    }
}
