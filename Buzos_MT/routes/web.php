<?php

use App\Http\Controllers\ProfileController;
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

<<<<<<< Updated upstream
=======
// Rutas de 'Perfil de Producción'
Route::get('/produccion', function () {
    return view('Perfil_Produccion.produccion');
})->name('produccion');

Route::get('/productos-fabricados', function(){
    return view('Perfil_Produccion.pro_fabricados');
})->name('pro_fabricados');

// Rutas de 'Perfil de administrador'
Route::get('/user-new', function () {
    return view('admin-usuario.user-new');
})->name('user-new');

Route::get('/user-list', function () {
    return view('admin-usuario.user-list');
})->name('user-list');

Route::get('/user-search', function () {
    return view('admin-usuario.user-search');
})->name('user-search');

Route::get('/user-update', function () {
    return view('admin-usuario.user-update');
})->name('user-update');

Route::get('/cargos', function () {
    return view('admin-usuario.cargos');
})->name('cargos');

Route::get('/tipoDocumentos', function () {
    return view('admin-usuario.tipoDocumentos');
})->name('tipoDocumentos');

Route::get('/user-list-cargo', function () {
    return view('admin-usuario.user-list-cargo');
})->name('user-list-cargo');

Route::get('/vistaEstados', function () {
    return view('admin-usuario.vistaEstados');
})->name('vistaEstados');

>>>>>>> Stashed changes
require __DIR__.'/auth.php';
