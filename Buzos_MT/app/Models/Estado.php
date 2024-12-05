<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $primaryKey = 'id_estados';

    protected $table = 'estados';

    protected $fillable = ['nombre_estado'];

    public $timestamps = false;

    public function tareas ()
    {
        return $this->hasMany(Tarea::class, 'tar_estado', 'id_estados');
    }

    public function materiaPrima ()
    {
        return $this->hasMany(MateriaPrima::class,'mat_pri_estado','id_estados');
    }
}
