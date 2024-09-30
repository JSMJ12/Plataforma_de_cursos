<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'name',
        'name2',
        'apellidop',
        'apellidom',
        'email',
        'ciudad',
        'celular',
        'nivel_estudio',
        'titulo',
        'especialidad',
        'image',
        'anos_experiencia',
        'edad',
        'password',
        'sexo',
        'interes',
        'programa_maestria',
        'fecha_graduacion',
        'empleado_actualmente',
        'nombre_empresa',
        'cargo_actual',
        'trabajo_vinculado',
        'anos_experiencia_laboral',
        'empleos_desde_graduacion',
        'estudios_adicionales',
        'desarrollo_profesional_continuo',
        'pertinencia_formacion',
        'satisfaccion_programa',
        'aspectos_utiles',
        'aspectos_mejorables',
        'actividades_investigacion',
        'recomendar_programa',
        'interes_capacitacion_continua',
        'temas_interes',
        'resolucion_de_problemas',
        'comunicacion_oral',
        'analisis',
        'creatividad',
        'trabajo_en_equipo',
        'cv'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->name2} {$this->apellidop} {$this->apellidom}";
    }

    /**
     * Get the user's age.
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        return $this->edad;
    }

    /**
     * Get the user's profile image.
     *
     * @return string
     */
    public function adminlte_image()
    {
        return $this->image ? asset('storage/'.$this->image) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'capacitador_id');
    }
    
    public function registros()
    {
        return $this->hasMany(Registro::class, 'usuario_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'usuario_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'usuario_id');
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'user_id');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'user_id');
    }
}
