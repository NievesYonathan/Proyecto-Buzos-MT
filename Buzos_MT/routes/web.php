<?php 

use App\Http\Controllers\produccionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoDocController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ListaCargoController;
use App\Http\Controllers\MateriaPrimaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TareaController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

//Rutas para login con Google
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login-google');

Route::get('/callback-url', function () {
    $user = Socialite::driver('google')->user();

    $userExists = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

    if ($userExists){
        Auth::login($userExists);
    } else {
        // Crear el usuario en la tabla usuarios
        $userNew = User::create([
            'num_doc' => $user->num_doc,
            't_doc' => $user->t_doc,
            'usu_nombres' => $user->usu_nombres,
            'usu_apellidos' => $user->usu_apellidos,
            'usu_email' => $user->usu_email,
            'usu_fecha_nacimiento' => $user->usu_fecha_nacimiento,
            'usu_sexo' => $user->usu_sexo,
            'usu_direccion' => 'NULL',
            'usu_telefono' => $user->usu_telefono,
            'usu_estado' => 1,
            'usu_fecha_contratacion' => now(), // Asignar la fecha de contratación actual
        ]);
        Auth::login($userNew);
    }

    return redirect(route('dashboard', absolute: false));
});

//rutas de 'perfil-admin-usuario'
Route::get('/usuario', [UserController::class, 'index'])->name('user-list');
Route::get('/user/new', [UserController::class, 'create'])->name('user-new');
Route::post('/user/new', [UserController::class, 'store'])->name('user-store');
Route::put('/usuarios/{num_doc}', [UserController::class, 'update'])->name('user-update');
Route::put('usuario/cambiar-estado/{num_doc}', [UserController::class, 'cambiarestado'])->name('user-cambiarestado');
Route::get('/usuarios/buscar', [UserController::class, 'buscar'])->name('user-search');

//Rutas de 'Tipos de Documentos'
Route::get('/tipo-documentos', [TipoDocController::class, 'index'])->name('tipoDocumentos');
Route::get('/tipoDoc/new', [TipoDocController::class, 'create'])->name('tipoDocumentos.create');
Route::post('/tipoDoc/new', [TipoDocController::class, 'store'])->name('tipoDocumentos.store');
Route::put('/tipo-documentos', [TipoDocController::class, 'update'])->name('tipoDocumentosP');
Route::get('/estados', [EstadoController::class, 'index'])->name('vistaEstados');
Route::post('/estados', [EstadoController::class, 'store'])->name('estado.store');
Route::put('/estados/{id}', [EstadoController::class, 'update'])->name('estado.update');

//Rutas de 'Cargos'
Route::get('/cargo', [CargoController::class, 'index'])->name('cargos');
Route::post('/cargo', [CargoController::class, 'store'])->name('cargos.store');
Route::put('/cargo/{id_cargos}', [CargoController::class, 'update'])->name('cargos.update');
Route::get('/usuarios', [ListaCargoController::class, 'index'])->name('user-list-cargo');
Route::post('/usuarios/asignar-cargo', [ListaCargoController::class, 'store'])->name('cargosUsuarios.store');
//rutas RR.HH
Route::get('/informes', [InformeController::class, 'index'])->name('informe-RRHH');
Route::get('/informes/users', [InformeController::class, 'fetchUsers'])->name('informes-RRHH.fetchUsers');

// Rutas de 'Perfil de Producción'
Route::get('/produccion', [produccionController::class, 'indexTwo'])->name('produccion');
Route::put('/produccion/{id}', [produccionController::class, 'update'])->name('update_produccion');
Route::get('/productos-fabricados', [produccionController::class, 'index'])->name('pro_fabricados');
Route::post('/productos-formulario', [produccionController::class, 'store'])->name('nuevo-producto');

//Rutas de 'Tarea'
Route::post('/tareas-crear', [TareaController::class, 'store'])->name('nueva_tarea');
Route::get('/tareas-produccion', [TareaController::class, 'index'])->name('pro_tareas');
Route::put('/tarea-actualizar/{id}', [TareaController::class, 'update'])->name('update_tarea');

//Rutas de 'Perfil Operario'
Route::get('/tareas-asigadas', [TareaController::class, 'tareasAsignadas'])->name('tareas-asigadas');

// Nuevas Rutas para editar y actualizar el estado de una tarea
Route::get('/tarea/editar/{id_tarea}/{id_empleado_tarea}', [TareaController::class, 'editarEstado'])->name('tarea.editar');
Route::post('/tarea/actualizar/{id_tarea}/{id_empleado_tarea}', [TareaController::class, 'actualizarEstado'])->name('tarea.actualizarEstado');

// Rutas para 'Jefe Materia Prima'
Route::get('/materia-prima', [MateriaPrimaController::class, 'index'])->name('lista-item');
Route::get('/materia-prima-agregar-formulario', [MateriaPrimaController::class, 'form_nuevo'])->name('vistaForm');
Route::post('/materia-prima-detalles/{id}', [MateriaPrimaController::class, 'show'])->name('Detalles-producto');
Route::get('/materia-prima-buscar', [MateriaPrimaController::class, 'showSearchForm'])->name('buscar-producto');
Route::post('/materia-prima-resultados', [MateriaPrimaController::class, 'search'])->name('resultados-producto');
Route::post('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'edit'])->name('editar-producto');

require __DIR__ . '/auth.php';