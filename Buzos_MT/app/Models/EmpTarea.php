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
}
