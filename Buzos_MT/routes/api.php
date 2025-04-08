<?php

use App\Http\Controllers\Api\BuzosImageController;
use App\Http\Controllers\Api\EmpTareasController;
use App\Http\Controllers\Api\ProduccionController;
use App\Http\Controllers\MateriaPrimaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\EtapaController;

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
// Route::post('/materia-prima-detalles/{id}', [MateriaPrimaController::class, 'show'])->name('Detalles-producto');
Route::post('/materia-prima-agregar', [MateriaPrimaController::class, 'store'])->name('reg-nuevo-producto-api');
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class,'update'])->name('update-producto');
Route::delete('/materia-prima/{id}', [MateriaPrimaController::class, 'delete'])->name('materia-prima-delete');




// Rutas para 'Jefe Producción'
Route::get('/producciones', [ProduccionController::class, 'index']);
Route::get('/produccion/{id}', [ProduccionController::class, 'show']);
Route::post('/nueva-produccion', [ProduccionController::class, 'store']);
Route::put('/produccion-editar/{id}', [ProduccionController::class, 'update']);
Route::patch('/produccion-editar-selec/{id}', [ProduccionController::class, 'updatePartial']);
Route::delete('/produccion-eliminar/{id}', [ProduccionController::class, 'destroy']);

Route::post('/produccion-tareas/{id}', [EmpTareasController::class, 'store']);
