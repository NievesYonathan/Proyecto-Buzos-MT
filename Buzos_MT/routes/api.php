<?php

use App\Http\Controllers\Api\BuzosImageController;

use App\Http\Controllers\Api\EmpTareaController;
use App\Http\Controllers\Api\ProduccionController;
use App\Http\Controllers\Api\RegProMateriaPrimaController;
use App\Http\Controllers\Api\MateriaPrimaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\EtapaController;
use App\Models\RegProMateriaPrima;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\api\TipoDocApiController;
use App\Http\Controllers\API\ListaCargoApiController;
use App\Http\Controllers\API\CargoApiController;
use App\Http\Controllers\API\EstadoApiController;

// Rutas para gestión de imágenes de usuarios
Route::post('/user/image/{id}', [UserProfileController::class, 'storeImage'])->name('storeImage');
Route::get('/user/image/{id}', [UserProfileController::class, 'getImage']);
Route::put('/user/image/{id}', [UserProfileController::class, 'updateImage'])->name('updateImage');
Route::delete('/user/image/delete/{id}', [UserProfileController::class, 'deleteImage'])->name('deleteImage');

// Rutas para gestión de imágenes de buzos
Route::post('/producto/image/{id}', [BuzosImageController::class, 'storeImagePro'])->name('storeImagePro');
Route::delete('/producto/image/delete/{id}', [BuzosImageController::class, 'deleteImagePro'])->name('deleteImagePro');

// Rutas para 'Jefe Materia Prima'
Route::get('/materia-prima', [MateriaPrimaController::class, 'index'])->name('lista-de-item');
Route::post('/materia-prima-detalles/{id}', [MateriaPrimaController::class, 'show'])->name('Detalles-producto2');
Route::post('/materia-prima-agregar', [MateriaPrimaController::class, 'store'])->name('reg-nuevo-producto2');
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class,'update'])->name('update-producto');
Route::delete('/materia-prima/{id}', [MateriaPrimaController::class, 'delete'])->name('materia-prima-delete');



// Rutas para 'Jefe Producción'
Route::get('/producciones', [ProduccionController::class, 'index']);
Route::get('/produccion/{id}', [ProduccionController::class, 'show']);
Route::post('/nueva-produccion', [ProduccionController::class, 'store']);
Route::put('/produccion-editar/{id}', [ProduccionController::class, 'update'])->name('update_produccion_api');
Route::patch('/produccion-editar-selec/{id}', [ProduccionController::class, 'updatePartial']);
Route::delete('/produccion-eliminar/{id}', [ProduccionController::class, 'destroy']);
Route::post('/nueva-prod-matPrima/{id}', [RegProMateriaPrimaController::class, 'store']);
Route::put('/editar-materiaPrima', [RegProMateriaPrimaController::class, 'update'])->name('update_mPrima_api');
Route::delete('/eliminar-materiaPrima/{id}', [RegProMateriaPrimaController::class, 'destroy']);

Route::post('/produccion-tareas/{id}', [EmpTareaController::class, 'store']);
Route::put('/produccion-tareas-editar', [EmpTareaController::class, 'update'])->name('update_tareas_api');
Route::delete('/produccion-tareas-eliminar/{id}', [EmpTareaController::class, 'destroy']);

// Rutas para el CRUD de Etapas
Route::get('/etapas', [EtapaController::class, 'index']); // Obtener todas las etapas
Route::post('/etapas', [EtapaController::class, 'store']); // Crear una nueva etapa
Route::get('/etapas/{id}', [EtapaController::class, 'show']); // Obtener una etapa por ID
Route::put('/etapas/{id}', [EtapaController::class, 'update']); // Actualizar una etapa
Route::delete('/etapas/{id}', [EtapaController::class, 'destroy']); // Eliminar una etapa
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'update'])->name('update-producto');

// API materia prima
Route::apiResource('materia-prima', MateriaPrimaController::class);

//API CRUD Administrador de usuarios
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UserApiController::class, 'index']);
    Route::post('/', [UserApiController::class, 'store']);
    Route::put('/{num_doc}', [UserApiController::class, 'update']);
    Route::put('/{num_doc}/estado', [UserApiController::class, 'cambiarEstado']);
    Route::get('/buscar', [UserApiController::class, 'buscar']);
    Route::get('/cargos', [UserApiController::class, 'mostrarConCargos']);
});

//APItipos documentos
Route::apiResource('tipos-documentos', TipoDocApiController::class);

//APIlista cargos 
Route::get('/lista-cargo', [ListaCargoApiController::class, 'index']);
Route::post('/lista-cargo', [ListaCargoApiController::class, 'store']);

//APIcargos
Route::get('/cargos', [CargoApiController::class, 'index']);
Route::post('/cargos', [CargoApiController::class, 'store']);
Route::put('/cargos/{id_cargos}', [CargoApiController::class, 'update']);

//APIestado
Route::get('/estados', [EstadoApiController::class, 'index']);
Route::post('/estados', [EstadoApiController::class, 'store']);
Route::put('/estados/{id_estados}', [EstadoApiController::class, 'update']);





