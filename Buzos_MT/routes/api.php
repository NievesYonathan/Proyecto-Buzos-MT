<?php

use App\Http\Controllers\Api\BuzosImageController;
use App\Http\Controllers\API\MateriaPrimaController;
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

// Rutas para 'Jefe inventario'
Route::get('/materia-prima', [MateriaPrimaController::class, 'index'])->name('lista-de-item');
Route::post('/materia-prima-agregar', [MateriaPrimaController::class, 'store'])->name('reg-nuevo-producto');
<<<<<<< HEAD
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class,'update'])->name('update-producto');
Route::delete('/materia-prima/{id}', [MateriaPrimaController::class, 'delete'])->name('materia-prima-delete');

// Rutas para el CRUD de Etapas
Route::get('/etapas', [EtapaController::class, 'index']); // Obtener todas las etapas
Route::post('/etapas', [EtapaController::class, 'store']); // Crear una nueva etapa
Route::get('/etapas/{id}', [EtapaController::class, 'show']); // Obtener una etapa por ID
Route::put('/etapas/{id}', [EtapaController::class, 'update']); // Actualizar una etapa
Route::delete('/etapas/{id}', [EtapaController::class, 'destroy']); // Eliminar una etapa
=======
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'update'])->name('update-producto');

// API materia prima
Route::apiResource('materia-prima', MateriaPrimaController::class);

>>>>>>> migracion-materia-prima
