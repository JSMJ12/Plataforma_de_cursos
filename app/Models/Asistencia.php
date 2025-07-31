<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'itinerario_id',
        'usuario_id',
        'asistio',
    ];

    /**
     * Get the itinerario that owns the Asistencia.
     */
    public function itinerario()
    {
        return $this->belongsTo(Itinerario::class);
    }

    /**
     * Get the user that owns the Asistencia.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
