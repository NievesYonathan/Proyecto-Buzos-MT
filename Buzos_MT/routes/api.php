<?php

use App\Http\Controllers\Api\BuzosImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserProfileController;

// Rutas para gestión de imagenes de usuarios
Route::patch('/user/profile/image', [UserProfileController::class, 'uploadImage'])->name('uploadImage');
Route::get('/user/profile/image/{id}', [UserProfileController::class, 'getImage']);

// Rutas para gestión de imagenes de buzos
Route::patch('/producto/image', [BuzosImageController::class, 'uploadImageBuzos'])->name('uploadImageBuzos');
