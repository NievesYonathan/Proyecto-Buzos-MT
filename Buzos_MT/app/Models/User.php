<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Especifica la tabla asociada con el modelo
    protected $table = 'usuarios';

    // Define la clave primaria
    protected $primaryKey = 'num_doc';

    // Atributos que son asignables en masa
    protected $fillable = [
        'num_doc',
        't_doc',
        'usu_nombres',
        'usu_apellidos',
        'usu_fecha_nacimiento',
        'usu_sexo',
        'usu_direccion',
        'usu_telefono',
        'email',
        'usu_fecha_contratacion',
        'usu_estado',
        'imag_perfil',
        'external_id',
        'external_auth'
    ];

    // Atributos que deben estar ocultos para la serialización
    protected $hidden = [
        'remember_token',
    ];

    // Atributos que deben ser lanzados a tipos específicos
    protected $casts = [
        'usu_fecha_nacimiento' => 'date',
        'usu_fecha_contratacion' => 'date',
    ];

    public $timestamps = false; // Deshabilitar timestamps
    protected $remember_token = null;

    // Relación con el modelo Seguridad
    public function seguridad()
    {
        return $this->hasOne(Seguridad::class, 'usu_num_doc', 'num_doc');
    }

    public function cargos()
    {
        return $this->belongsToMany(Cargo::class, 'cargos_has_usuarios', 'usuarios_num_doc', 'cargos_id_cargos')->withPivot('fecha_asignacion');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDoc::class, 't_doc', 'id_tipo_documento');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'usu_estado', 'id_estados');
    }

    public function tareasAsignadas()
    {
        return $this->belongsToMany(Tarea::class, 'emp_tarea', 'empleados_num_doc', 'tarea_id_tarea');
    }

    public function materiaPrima ()
    {
        return $this->hasMany(MateriaPrima::class, 'proveedores_id_proveedores', 'num_doc');
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

}
