<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguridad extends Model
{
    use HasFactory;

    /**
     * Especifica la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'seguridad';

    /**
     * Desactiva las marcas de tiempo, ya que no están definidas en la tabla.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usu_num_doc',
        'seg_clave_hash',
    ];

    /**
     * Define la relación con el modelo User.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usu_num_doc', 'numero_documento');
    }
}
