<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserProfileController;

Route::patch('/user/profile/image', [UserProfileController::class, 'uploadImage'])->name('uploadImage');
Route::get('/user/profile/image/{id}', [UserProfileController::class, 'getImage']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
