<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDoc extends Model
{
    use HasFactory;

    protected $table = 'tipo_doc';

    public $timestamps = false;
}
