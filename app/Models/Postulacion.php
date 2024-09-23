<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = ['user_id', 'trabajo_id', 'estado'];

    // Relación con el usuario (Una postulación pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el trabajo (Una postulación pertenece a un trabajo)
    public function trabajo()
    {
        return $this->belongsTo(Trabajo::class);
    }
}
