<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;

class CargoApiController extends Controller
{
    public function index()
    {
        return response()->json(Cargo::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_nombre' => 'required|string|max:255',
        ]);

        $cargo = Cargo::create([
            'car_nombre' => $request->car_nombre,
        ]);

        return response()->json($cargo, 201);
    }

    public function update(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);

        $cargo->update([
            'car_nombre' => $request->car_nombre,
        ]);

        return response()->json($cargo, 200);
    }
}
