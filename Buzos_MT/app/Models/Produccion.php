<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;

    protected $table = 'produccion';

    protected $primaryKey = 'id_produccion';

    protected $fillable = [
        'pro_nombre',
        'pro_fecha_inicio',
        'pro_fecha_fin',
        'pro_cantidad',
        'pro_etapa',
        'pro_img'
    ];

    protected $casts = [
        'pro_fecha_inicio' => 'datetime',
        'pro_fecha_fin' => 'datetime',
    ];

    public $timestamps = false;

    public function etapa ()
    {
        return $this->belongsTo(Etapas::class, 'pro_etapa', 'id_etapas');
    }

    public function regProFabricados ()
    {
        return $this->hasMany(RegProFabricado::class, 'produccion_id_produccion', 'id_produccion');
    }

    public function materiasPrimas ()
    {
        return $this->belongsToMany(MateriaPrima::class, 'reg_pro_mat_prima', 'id_produccion', 'id_pro_materia_prima')->withPivot('id_registro', 'reg_pmp_cantidad_usada');
    }

    public function tareas ()
    {
        return $this->belongsToMany(Tarea::class, 'emp_tarea', 'produccion_id_produccion', 'tarea_id_tarea')->withPivot('id_empleado_tarea', 'emp_tar_fecha_entrega', 'empleados_num_doc');
    }

}
