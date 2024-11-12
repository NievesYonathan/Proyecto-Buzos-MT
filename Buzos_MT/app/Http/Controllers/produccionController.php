<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use Illuminate\Http\Request;

class produccionController extends Controller
{
    public function index()
    {
        $producciones = Produccion::with('etapa', 'regProFabricados', 'materiaPrima', 'tareas')->get();

        return view('Perfil_Produccion.pro_fabricados', compact('producciones'));    
    }

}
