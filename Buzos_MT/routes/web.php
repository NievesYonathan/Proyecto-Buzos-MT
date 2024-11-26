<?php

use App\Http\Controllers\produccionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoDocController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//rutas de 'perfil-admin-usuario'
Route::get('/usuarios', [UserController::class, 'index'])->name('user-list');
Route::get('/user/new', [UserController::class, 'create'])->name('user-new');
Route::post('/user/new', [UserController::class, 'store'])->name('user-store');
Route::post('/usuarios/{num_doc}/update', [UserController::class, 'update'])->name('user-update');
Route::post('/usuarios/{num_doc}/delete', [UserController::class, 'destroy'])->name('user-delete');
Route::get('/usuarios/buscar', [UserController::class, 'buscar'])->name('user-search');
Route::get('/tipo-documentos', [TipoDocController::class, 'index'])->name('tipoDocumentos.index');
Route::post('/tipo-documentos', [TipoDocController::class, 'store'])->name('tipoDocumentos.store');
Route::put('/tipo-documentos/{id}', [TipoDocController::class, 'update'])->name('tipoDocumentos.update');
Route::get('/estados', [EstadoController::class, 'index'])->name('vistaEstados');
Route::post('/estados', [EstadoController::class, 'store'])->name('estado.store');
Route::put('/estados/{id}', [EstadoController::class, 'update'])->name('estado.update');
Route::get('/usuario/actualizar', [UserController::class, 'mostrarFormulario'])->name('usuario.formulario');
Route::post('/usuario/actualizar', [UserController::class, 'actualizar'])->name('usuario.actualizar');


// Rutas de 'Perfil de Producción'
Route::get('/produccion', [produccionController::class, 'indexTwo'])->name('produccion');
Route::put('/produccion/{id}', [produccionController::class, 'update'])->name('update_produccion');
Route::get('/productos-fabricados', [produccionController::class, 'index'])->name('pro_fabricados');
Route::post('/productos-formulario', [produccionController::class, 'store'])->name('nuevo-producto');

//Rutas de 'Tarea'
Route::post('/tareas-crear', [TareaController::class, 'store'])->name('nueva_tarea');
Route::get('/tareas-produccion', [TareaController::class, 'index'])->name('pro_tareas');
Route::put('/tarea-actualizar/{id}', [TareaController::class, 'update'])->name('update_tarea');

require __DIR__ . '/auth.php';
