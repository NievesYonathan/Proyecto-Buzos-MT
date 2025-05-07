<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDoc extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tipo_documento';  // Asegúrate de usar el nombre de columna correcto
    protected $table = 'tipo_doc';
    protected $fillable = ['tip_doc_descripcion']; // Campo que recibirá el nombre del tipo de documento

    public $timestamps = false;
}
