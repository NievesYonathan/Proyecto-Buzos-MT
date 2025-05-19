<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaProductos extends Model
{
    use HasFactory;

    protected $table = 'salida_productos';

    protected $primaryKey = 'id_salida_productos';

    protected $fillable = [
        'sal_pro_cantidad',
        'sal_pro_fecha',
        'sal_pro_destino',
        'id_reg_prod_fabricados',
        'id_motivo',
        'id_usuario'
    ];

    public $timestamps = false;
}
