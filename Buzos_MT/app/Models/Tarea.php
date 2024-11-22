<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tarea';

    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'tar_nombre',
        'tar_descripcion',
        'tar_estado'
    ];

    public $timestamps = false;

    public function produccion ()
    {
        return $this->belongsToMany(Produccion::class, 'emp_tarea', 'tarea_id_tarea', 'produccion_id_produccion')->withPivot('emp_tar_fecha_entrega', 'empleados_num_doc');
    }

    public function estados ()
    {
        return $this->belongsTo(Estado::class, 'tar_estado', 'id_estados');
    }
}
