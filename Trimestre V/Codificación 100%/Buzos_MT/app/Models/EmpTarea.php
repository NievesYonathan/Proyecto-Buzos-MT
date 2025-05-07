<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpTarea extends Model
{
    use HasFactory;

    protected $table = 'emp_tarea';

    protected $primaryKey = 'id_empleado_tarea';

    protected $fillable = [
        'empleados_num_doc',
        'tarea_id_tarea',
        'emp_tar_fecha_asignacion',
        'emp_tar_fecha_entrega',
        'emp_tar_estado_tarea',
        'produccion_id_produccion'
    ];

    public $timestamps = false;

    public function produccion()
    {
        return $this->belongsTo(Produccion::class, 'produccion_id_produccion', 'id_produccion');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id_tarea', 'id_tarea');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleados_num_doc', 'num_doc');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'emp_tar_estado_tarea', 'id_estados');
    }
}
