<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    use HasFactory;

    protected $table = 'materia_prima';

    protected $primaryKey = 'id_materia_prima';

    protected $fillable = [
        'mat_pri_nombre',
        'mat_pri_descripcion',
        'mat_pri_unidad_medida',
        'mat_pri_cantidad',
        'mat_pri_estado',
        'fecha_compra_mp',
        'proveedores_id_proveedores'
    ];

    public $timestamps = false;

    public function produccion ()
    {
        return $this->belongsToMany(Produccion::class, 'reg_pro_mat_prima', 'id_produccion', 'id_pro_materia_prima')->withPivot('reg_pmp_cantidad_usada');
    }
}
