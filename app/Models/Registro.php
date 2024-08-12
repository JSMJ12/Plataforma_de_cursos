<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'usuario_id',
        'tipo_participante',
        'aprobado',
    ];

    /**
     * Get the curso that owns the Registro.
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Get the user that owns the Registro.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
