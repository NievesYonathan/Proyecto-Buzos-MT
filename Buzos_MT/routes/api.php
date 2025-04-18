<?php
use App\Http\Controllers\Api\BuzosImageController;
use App\Http\Controllers\Api\ApiAuthenticatedSessionController;
use App\Http\Controllers\Api\ApiRegisteredUserController;
use App\Http\Controllers\Api\EmpTareasController;
use App\Http\Controllers\Api\ProduccionController;
use App\Http\Controllers\Api\RegProMateriaPrimaController;
use App\Http\Controllers\Api\MateriaPrimaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\EtapaController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\TipoDocApiController;
use App\Http\Controllers\Api\EstadoApiController;
use App\Http\Controllers\Api\CargoApiController;
use App\Http\Controllers\Api\ListaCargoApiController;
use App\Http\Controllers\Api\TareaApiController;

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
Route::post('/materia-prima-detalles/{id}', [MateriaPrimaController::class, 'show'])->name('Detalles-producto');
Route::post('/materia-prima-agregar', [MateriaPrimaController::class, 'store'])->name('reg-nuevo-producto');
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'update'])->name('update-producto');
Route::delete('/materia-prima/{id}', [MateriaPrimaController::class, 'delete'])->name('materia-prima-delete');
//Rutas para la Api de la aplicacion mobile

Route::get('/Login', [ApiAuthenticatedSessionController::class, 'create']);
Route::post('/Login', [ApiAuthenticatedSessionController::class, 'store']);
Route::post('/Register',[ApiRegisteredUserController::class, 'store']);
// Route::get('/Register',[ApiRegisteredUserController::class, 'create']);
Route::middleware('jwt')->delete('/logout', [ApiAuthenticatedSessionController::class, 'destroy']);



// Rutas para 'Jefe Producción'
Route::get('/producciones', [ProduccionController::class, 'index']);
Route::get('/produccion/{id}', [ProduccionController::class, 'show']);
Route::post('/nueva-produccion', [ProduccionController::class, 'store']);
Route::post('/nueva-prod-matPrima/{id}', [RegProMateriaPrimaController::class, 'store']);
Route::put('/produccion-editar/{id}', [ProduccionController::class, 'update']);
Route::patch('/produccion-editar-selec/{id}', [ProduccionController::class, 'updatePartial']);
Route::delete('/produccion-eliminar/{id}', [ProduccionController::class, 'destroy']);

Route::post('/produccion-tareas/{id}', [EmpTareasController::class, 'store']);

// Rutas para el CRUD de Etapas
Route::get('/etapas', [EtapaController::class, 'index']); // Obtener todas las etapas
Route::post('/etapas', [EtapaController::class, 'store']); // Crear una nueva etapa
Route::get('/etapas/{id}', [EtapaController::class, 'show']); // Obtener una etapa por ID
Route::put('/etapas/{id}', [EtapaController::class, 'update']); // Actualizar una etapa
Route::delete('/etapas/{id}', [EtapaController::class, 'destroy']); // Eliminar una etapa
Route::put('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'update'])->name('update-producto');

// API materia prima
Route::apiResource('materia-prima', MateriaPrimaController::class);

// Rutas para usuarios
Route::controller(UserApiController::class)->group(function () {
    Route::get('/usuarios', 'index');
    Route::post('/usuarios', 'store');
    Route::put('/usuarios/{num_doc}', 'update');
    Route::put('/usuarios/cambiar-estado/{num_doc}', 'cambiarEstado');
    Route::get('/usuarios/buscar', 'buscar');
    Route::get('/tipos-documentos', 'getTiposDocumentos');
    Route::get('/estados', 'getEstados');
});

//rutas tipos documentos
Route::get('/tipos-documentos', [TipoDocApiController::class, 'index']);
Route::post('/tipos-documentos', [TipoDocApiController::class, 'store']);
Route::put('/tipos-documentos/{id}', [TipoDocApiController::class, 'update']);


//estados
Route::prefix('estados')->group(function () {
    Route::get('/', [EstadoApiController::class, 'index']);          // Obtener todos los estados
    Route::post('/', [EstadoApiController::class, 'store']);         // Crear un nuevo estado
    Route::put('/{id_estados}', [EstadoApiController::class, 'update']); // Actualizar un estado
    Route::delete('/{id_estados}', [EstadoApiController::class, 'destroy']); // Eliminar un estado
});

//cargos
Route::get('/cargos', [CargoApiController::class, 'index']);
Route::post('/cargos', [CargoApiController::class, 'store']);
Route::put('/cargos/{id}', [CargoApiController::class, 'update']);
Route::get('/usuarios-cargos', [ListaCargoApiController::class, 'index']);
Route::post('/usuarios-cargos', [ListaCargoApiController::class, 'store']);


//tareas
Route::get('/tareas', [TareaApiController::class, 'index']); // Mostrar todas las tareas
Route::post('/tareas', [TareaApiController::class, 'store']); // Crear tarea
Route::put('/tareas/{id}', [TareaApiController::class, 'update']); // Actualizar tarea

// Rutas de tareas asignadas a un operario
Route::get('/tareas-asignadas', [TareaApiController::class, 'tareasAsignadas']);

// Rutas para editar estado de tareas asignadas
Route::get('/tareas/estado/{id_tarea}/{id_empleado_tarea}', [TareaApiController::class, 'editarEstado']);
Route::put('/tareas/estado/{id_empleado_tarea}', [TareaApiController::class, 'actualizarEstado']);
