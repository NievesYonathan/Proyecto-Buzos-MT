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
use App\Http\Controllers\ReporteProduccionController;
use App\Http\Controllers\Api\EtapaController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    try {
        // Primero veamos la configuración actual
        $config = [
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'from' => config('mail.from.address'),
            'to' => 'yonathannieves17@gmail.com'
        ];

        dd($config); // Esto nos mostrará la configuración antes de intentar enviar

        Mail::raw('Test email content', function ($message) {
            $message->to('yonathannieves17@gmail.com')
                ->subject('Test Email')
                ->from(config('mail.from.address'), config('mail.from.name'));
        });

        return [
            'status' => 'success',
            'message' => 'Email sent successfully!',
            'config' => $config
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // emotify('success', 'You are awesome, your data was successfully created');
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

    if ($userExists) {
        Auth::login($userExists);
    } else {
        // Crear el usuario en la tabla usuarios
        $userNew = User::create([
            'num_doc' => $user->num_doc,
            't_doc' => $user->t_doc,
            'usu_nombres' => $user->usu_nombres,
            'usu_apellidos' => $user->usu_apellidos,
            'email' => $user->email,
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
Route::controller(UserController::class)->group(function () {
    Route::get('/user-list', 'index')->name('user-list');
    Route::get('/user-new', 'create')->name('user-new');
    Route::post('/user-store', 'store')->name('user-store');
    Route::put('/user-update/{num_doc}', 'update')->name('user-update');
    Route::put('/user-cambiar-estado/{num_doc}', 'cambiarestado')->name('user-cambiarestado');
    Route::get('/user-search', 'buscar')->name('user-search');
    Route::get('/informes', [InformeController::class, 'index'])->name('informe-RRHH');
    Route::get('/informes/users', [InformeController::class, 'fetchUsers'])->name('informes-RRHH.fetchUsers');
});

// rutas tipo-doc
Route::controller(TipoDocController::class)->group(function () {
    Route::get('/tipo-documentos', 'index')->name('tipo-documentos');
    Route::get('/tipo-documentos/new', 'create')->name('tipo-documentos.new');
    Route::post('/tipo-documentos', 'store')->name('tipo-documentos.store');
    Route::put('/tipo-documentos/{id}', 'update')->name('tipo-documentos.update');
    Route::delete('/tipo-documentos/{id}', 'destroy')->name('tipo-documentos.delete');
});


//estados
Route::controller(EstadoController::class)->group(function () {
    Route::get('/estados', 'index')->name('vistaEstados');
    Route::get('/estados/new', 'create')->name('estados.new');
    Route::post('/estados', 'store')->name('estados.store');
    Route::put('/estados/{id_estados}', 'update')->name('estados.update');
});

//Rutas de 'Cargos'
Route::get('/cargos', [CargoController::class, 'index'])->name('cargos');
Route::get('/cargos/create', [CargoController::class, 'create'])->name('cargos.create');
Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');
Route::put('/cargos/{id}', [CargoController::class, 'update'])->name('cargos.update');
Route::get('/usuarios', [ListaCargoController::class, 'index'])->name('user-list-cargo2');
Route::get('/usuarios-cargos', [ListaCargoController::class, 'index'])->name('user-list-cargo');
Route::post('/usuarios-cargos', [ListaCargoController::class, 'store'])->name('cargosUsuarios.store');

// Rutas de 'Perfil de Producción'
Route::middleware('auth')->group(function () {
    Route::get('/produccion', [produccionController::class, 'indexTwo'])->name('produccion');
    Route::put('/produccion/{id}', [produccionController::class, 'update'])->name('update_produccion');
    Route::get('/productos-fabricados', [produccionController::class, 'index'])->name('pro_fabricados');
    Route::post('/productos-formulario', [produccionController::class, 'store'])->name('nuevo-producto');
});

// Rutas para las vistas
Route::get('/perfil-produccion/etapas', [EtapaController::class, 'indexView'])->name('perfil-produccion.etapas'); // Mostrar etapas
Route::post('/perfil-produccion/etapas', [EtapaController::class, 'storeFromView'])->name('perfil-produccion.etapas.store'); // Crear nueva etapa
Route::get('/perfil-produccion/etapas/{id}/edit', [EtapaController::class, 'updateView'])->name('perfil-produccion.etapas.edit'); // Editar etapa
Route::put('/perfil-produccion/etapas/{id}', [EtapaController::class, 'updateFromView'])->name('perfil-produccion.etapas.update'); // Actualizar etapa
Route::delete('/perfil-produccion/etapas/{id}', [EtapaController::class, 'destroy'])->name('perfil-produccion.etapas.destroy'); //para eliminar :)
//Rutas de 'Tarea'
Route::post('/tareas-crear', [TareaController::class, 'store'])->name('nueva_tarea');
Route::get('/tareas-produccion', [TareaController::class, 'index'])->name('pro_tareas');
Route::put('/tarea-actualizar/{id}', [TareaController::class, 'update'])->name('update_tarea');

// Rutas para las vistas
Route::get('/perfil-produccion/etapas', [EtapaController::class, 'indexView'])->name('perfil-produccion.etapas'); // Mostrar etapas
Route::post('/perfil-produccion/etapas', [EtapaController::class, 'storeFromView'])->name('perfil-produccion.etapas.store'); // Crear nueva etapa
Route::get('/perfil-produccion/etapas/{id}/edit', [EtapaController::class, 'updateView'])->name('perfil-produccion.etapas.edit'); // Editar etapa
Route::put('/perfil-produccion/etapas/{id}', [EtapaController::class, 'updateFromView'])->name('perfil-produccion.etapas.update'); // Actualizar etapa
Route::delete('/perfil-produccion/etapas/{id}', [EtapaController::class, 'destroy'])->name('perfil-produccion.etapas.destroy'); //para eliminar :)

//Rutas de 'Tarea'
Route::post('/tareas-crear', [TareaController::class, 'store'])->name('nueva_tarea');
Route::get('/tareas-produccion', [TareaController::class, 'index'])->name('pro_tareas');
Route::put('/tarea-actualizar/{id}', [TareaController::class, 'update'])->name('update_tarea');

//Rutas de 'Perfil Operario'
Route::get('/tareas-asignadas', [TareaController::class, 'tareasAsignadas'])->name('tareas-asignadas');

// Nuevas Rutas para editar y actualizar el estado de una tarea
Route::get('/tarea/editar/{id_tarea}/{id_empleado_tarea}', [TareaController::class, 'editarEstado'])->name('tarea.editar');
Route::post('/tarea/actualizar/{id_tarea}/{id_empleado_tarea}', [TareaController::class, 'actualizarEstado'])->name('tarea.actualizarEstado');

// Rutas para 'Jefe inventario'
Route::get('/materia-prima', [MateriaPrimaController::class, 'index'])->name('lista-item');
Route::get('/materia-prima-agregar-formulario', [MateriaPrimaController::class, 'form_nuevo'])->name('vistaForm');
Route::post('/nuevo-producto', [MateriaPrimaController::class, 'store'])->name('reg-nuevo-producto');
Route::get('/materia-prima-detalles/{id}', [MateriaPrimaController::class, 'show'])->name('Detalles-producto');
Route::get('/materia-prima-buscar', [MateriaPrimaController::class, 'showSearchForm'])->name('buscar-producto');
Route::post('/materia-prima-resultados', [MateriaPrimaController::class, 'search'])->name('resultados-producto');
Route::post('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'edit'])->name('editar-producto');
Route::get('/materia-prima-editar/{id}', [MateriaPrimaController::class, 'edit'])->name('editar-producto-get');
Route::get('/reporte-produccion', [ReporteProduccionController::class, 'index'])->name('reportes');

// Rutas para Tipos de Documento
Route::controller(TipoDocController::class)->group(function () {
    Route::get('/tipos-documentos', 'index')->name('tipoDocumentos');
    Route::post('/tipos-documentos', 'store')->name('tipoDocumentos.store');
    Route::put('/tipos-documentos/{id_tipo_documento}', 'update')->name('tipoDocumentos.update');
});

require __DIR__ . '/auth.php';
