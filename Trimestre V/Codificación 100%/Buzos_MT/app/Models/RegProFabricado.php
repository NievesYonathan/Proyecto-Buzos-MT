<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegProFabricado extends Model
{
    use HasFactory;

    protected $table = 'reg_pro_fabricados';

    protected $primaryKey = 'id_reg_prod_fabricados';

    protected $fillable = [
        'reg_pf_cantidad',
        'reg_pf_fecha_registro',
        'reg_pf_talla',
        'reg_pf_color',
        'reg_pf_material',
        'reg_pf_tipo_prenda',
        'produccion_id_produccion',
    ];

    public $timestamps = false;

    public function produccion ()
    {
        return $this->belongsTo(Produccion::class, 'produccion_id_produccion', 'id_produccion');
    }
}
