<x-app-layout>
    <div class="my-5">
        <div class="row">
            <div class="mb-5 col-sm-6 col-md-6 col-lg-5">
{{--                 <div class="pro-btns">
                    <div class="pro-btn">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#agregar">
                            <i class="fa-solid fa-square-plus fa-2xl" style="color: #2baf54;"></i>
                        </button>
                        <p>Gestionar Producción</p>
                    </div>
                    <!-- Modal para gestionar producción -->
                    <div class="modal fade" id="agregar" tabindex="-1" role="dialog" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Gestionar Producción:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="#" method="POST" class="form-neon" autocomplete="off">
                                        @csrf
                                        <fieldset>
                                            <legend><i class="fas fa-industry"></i> &nbsp; Información de la producción
                                            </legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_nombre"
                                                                class="bmd-label-floating">Nombre de
                                                                la Producción</label>
                                                            <input type="text"
                                                                class="form-control border border-dark"
                                                                name="produccion_nombre" id="produccion_nombre"
                                                                maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_fecha_inicio"
                                                                class="bmd-label-floating">Fecha de Inicio</label>
                                                            <input type="date"
                                                                class="form-control border border-dark"
                                                                name="produccion_fecha_inicio"
                                                                id="produccion_fecha_inicio" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_fecha_fin"
                                                                class="bmd-label-floating">Fecha
                                                                de Finalización</label>
                                                            <input type="date"
                                                                class="form-control border border-dark"
                                                                name="produccion_fecha_fin" id="produccion_fecha_fin"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <br><br><br>

                                        <fieldset>
                                            <legend><i class="fas fa-tasks"></i> &nbsp; Detalles de la Tarea</legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_tarea"
                                                                class="bmd-label-floating">Tarea
                                                                Asignada</label>
                                                            <input type="text"
                                                                class="form-control border border-dark"
                                                                name="produccion_tarea" id="produccion_tarea"
                                                                maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_estado"
                                                                class="bmd-label-floating">Estado de
                                                                la Producción</label>
                                                            <select class="form-control border border-dark"
                                                                name="produccion_estado" id="produccion_estado">
                                                                <option value="" selected disabled>Seleccione un
                                                                    estado
                                                                </option>
                                                                <option value="en_progreso">En Progreso</option>
                                                                <option value="completado">Completado</option>
                                                                <option value="pendiente">Pendiente</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_responsable"
                                                                class="bmd-label-floating">Responsable</label>
                                                            <input type="text"
                                                                class="form-control border border-dark"
                                                                name="produccion_responsable"
                                                                id="produccion_responsable" maxlength="50" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="text-center" style="margin-top: 40px;">
                                            <button type="reset" class="btn btn-secondary btn-sm"><i
                                                    class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                                            <button type="submit" class="btn btn-info btn-sm"><i
                                                    class="far fa-save"></i>
                                                &nbsp; GUARDAR</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Modal Producción -->

                    <div class="pro-btn">
                        <button type="button" name="tarea" value="tarea" class="btn" data-bs-toggle="modal"
                            data-bs-target="#tarea"><i class="fa-solid fa-file-circle-plus fa-2xl"
                                style="color: #2baf54;"></i></button>
                        <p>Gestionar Tareas</p>
                    </div>

                    <!-- Gestionar Tarea - Modal -->
                    <div class="modal fade" id="tarea" tabindex="-1" role="dialog" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered"
                            role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Gestionar Tareas:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="" class="form-neon" autocomplete="off">
                                        <fieldset>
                                            <legend><i class="far fa-address-card"></i> &nbsp; Información de la tarea
                                            </legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="estado_tarea"
                                                                class="bmd-label-floating">Tarea</label>
                                                            <select class="form-control" name="estado_tarea"
                                                                id="estado_tarea">
                                                                <option value="" selected="" disabled="">
                                                                    Seleccione una opción</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="En Proceso">En Proceso</option>
                                                                <option value="Completada">Completada</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="empleado_id" class="bmd-label-floating">ID del
                                                                Empleado</label>
                                                            <input type="text" pattern="[0-9]{1,20}"
                                                                class="form-control" name="empleado_id"
                                                                id="empleado_id" maxlength="20">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="fecha_asignacion"
                                                                class="bmd-label-floating">Fecha de
                                                                Asignación</label>
                                                            <input type="date" class="form-control"
                                                                name="fecha_asignacion" id="fecha_asignacion">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="fecha_entrega"
                                                                class="bmd-label-floating">Fecha de
                                                                Entrega</label>
                                                            <input type="date" class="form-control"
                                                                name="fecha_entrega" id="fecha_entrega">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br><br><br>
                                        <fieldset>
                                            <legend><i class="fas fa-user-lock"></i> &nbsp; Estado y Descripción
                                            </legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="estado_tarea"
                                                                class="bmd-label-floating">Estado de la
                                                                Tarea</label>
                                                            <select class="form-control" name="estado_tarea"
                                                                id="estado_tarea">
                                                                <option value="" selected="" disabled="">
                                                                    Seleccione una opción</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="En Proceso">En Proceso</option>
                                                                <option value="Completada">Completada</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="descripcion_tarea"
                                                                class="bmd-label-floating">Descripción de la
                                                                Tarea</label>
                                                            <textarea class="form-control" name="descripcion_tarea" id="descripcion_tarea" maxlength="200"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <p class="text-center" style="margin-top: 40px;">
                                            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i
                                                    class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                                            &nbsp; &nbsp;
                                            <button type="submit" class="btn btn-raised btn-info btn-sm"><i
                                                    class="far fa-save"></i> &nbsp; GUARDAR</button>
                                        </p>
                                    </form>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Modal Tarea -->
                </div>
 --}}
                <h4 class="pro-resumen-titulo">Resumen de Producciones:</h4>
                <div class="pro-resumen">
                    @foreach ($producciones as $produccion)
                    <div class="pro-res-detalle">
                        <p>Producción: <span>{{ $produccion->pro_nombre }}</span></p>
                        <p>Etapa: 
                            <span>
                                @foreach ($etapas as $etapa)
                                    @if ($etapa->id_etapas === $produccion->etapa->id_etapas) 
                                        {{ $etapa->eta_nombre }} 
                                    @endif
                                @endforeach
                            </span>
                        </p>
                        <button type="button" name="detalle" value="detalle" class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#selectionModal{{ $produccion->id_produccion }}">Ver Detalles</button>
                        <!-- <a href="#" class="pro-ver">Ver Detalles</a> -->
                    </div>
                    @endforeach
                </div>
        <!-- Modal de Selección -->
        @foreach ($producciones as $produccion)
        <div class="modal fade" id="selectionModal{{ $produccion->id_produccion }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seleccione qué desea editar</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-grid gap-3">
                            <button class="btn btn-primary" data-bs-toggle="modal" 
                                data-bs-target="#updateModalProduccion{{ $produccion->id_produccion }}"
                                data-bs-dismiss="modal">
                                <i class="fas fa-industry"></i> Editar Producción
                            </button>
                            <button class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#updateModalTareas{{ $produccion->id_produccion }}"
                                data-bs-dismiss="modal">
                                <i class="fas fa-tasks"></i> Editar Tareas
                            </button>
                            <button class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#updateModalMaterias{{ $produccion->id_produccion }}"
                                data-bs-dismiss="modal">
                                <i class="fas fa-pallet"></i> Editar Materias Primas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal-Ediciòn Producción -->
        @foreach ($producciones as $produccion)
        <div class="modal fade" id="updateModalProduccion{{ $produccion->id_produccion }}" tabindex="-1" role="dialog"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Gestionar Producción | {{ $produccion->id_produccion }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-8">
                                <form method="post" action="{{ route('storeImagePro', $produccion->id_produccion) }}" class="mt-6 space-y-6"
                                    enctype="multipart/form-data">
                                    @csrf
    
                                    <fieldset>
                                        <div class="row mb-6">
                                            <div class="col-6">
                                                <input type="file" name="pro_img" id="imageInput" accept="image/*">
                                            </div>
                                            <div class="col-6">
                                                <div class="flex items-center gap-4">
                                                    <x-primary-button>{{ __('Subir Imagen') }}</x-primary-button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>        
                            </div>

                            <div class="col-4">
                                <form class="mb-3" action="{{ route('deleteImagePro', $produccion->id_produccion) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex items-center gap-4">
                                        <x-danger-button>{{ __('Eliminar Imagen') }}</x-danger-button>
                                    </div>
                                </form>        
                            </div>
                        </div>

                        <form action="{{ route('update_produccion_api', $produccion->id_produccion) }}"
                            method="POST" class="form-neon ajax-form" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <fieldset>
                                <legend>
                                    <i class="fas fa-industry"></i> &nbsp; Información de la producción
                                </legend>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="produccion_nombre" class="bmd-label-floating">Nombre
                                                    de la Producción</label>
                                                <input type="text" class="form-control border border-dark"
                                                    name="produccion_nombre" id="produccion_nombre"
                                                    maxlength="50" value="{{ $produccion->pro_nombre }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="produccion_fecha_inicio"
                                                    class="bmd-label-floating">Fecha de Inicio</label>
                                                <input type="date" class="form-control border border-dark"
                                                    name="produccion_fecha_inicio"
                                                    value="{{ $produccion->pro_fecha_inicio->format('Y-m-d') }}"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="produccion_fecha_fin"
                                                    class="bmd-label-floating">Fecha de Finalización</label>
                                                <input type="date" class="form-control border border-dark"
                                                    name="produccion_fecha_fin" id="produccion_fecha_fin"
                                                    value="{{ $produccion->pro_fecha_fin->format('Y-m-d') }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="produccion_cantidad"
                                                    class="bmd-label-floating">Cantidad Produccida</label>
                                                <input type="number" class="form-control border border-dark"
                                                    name="produccion_cantidad" id="produccion_cantidad"
                                                    maxlength="50" value="{{ $produccion->pro_cantidad }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="produccion_etapa"
                                                    class="bmd-label-floating">Etapa</label>
                                                <select class="form-control border border-dark"
                                                    id="produccion_etapa" name="produccion_etapa" required>
                                                    @foreach ($etapas as $etapa)
                                                    <option value="{{ $etapa->id_etapas }}"
                                                        @if ($etapa->id_etapas === $produccion->etapa->id_etapas) selected @endif>
                                                        {{ $etapa->eta_nombre }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <br><br>

                            <p class="text-center" style="margin-top: 40px;">
                                <button type="reset" class="btn btn-raised btn-secondary btn-sm">
                                    <i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
                                </button>
                                &nbsp; &nbsp;
                                <button type="submit" name="btn-produccion" value="editar"
                                    class="btn btn-raised btn-success btn-sm">
                                    <i class="far fa-save"></i> &nbsp; GUARDAR
                                </button>
                            </p>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Model Producción -->
        @endforeach

        <!-- Modal-Ediciòn Materias Primas -->
        @foreach ($producciones as $produccion)
        <div class="modal fade" id="updateModalMaterias{{ $produccion->id_produccion }}" tabindex="-1" role="dialog"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Gestionar Producción | {{ $produccion->id_produccion }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('update_mPrima_api')}}"
                            method="POST" class="form-neon ajax-form" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_produccion" value="{{ $produccion->id_produccion }}">

                            <fieldset>
                                <legend><i class="fas fa-pallet fa-fw"></i> &nbsp; Detalles de Materia Prima
                                </legend>
                                <div class="container-fluid">
                                    <div class="row mt-3 mtprima-container">
                                        {{-- Template oculto para materia prima --}}
                                        <div class="row d-none">
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label for="produccion_mtPrima" class="bmd-label-floating">Materia Prima</label>
                                                    <select class="form-control border border-dark materia-prima-select" name="produccion_mtPrima[]">
                                                        @foreach ($materiasPrimas1 as $materiaPrima1)
                                                        <option value="{{ $materiaPrima1->id_materia_prima }}">
                                                            {{ $materiaPrima1->mat_pri_nombre }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label for="mtPrima_cantidad" class="bmd-label-floating">Cantidad</label>
                                                    <input type="number" class="form-control border border-dark cantidad-input" name="mtPrima_cantidad[]">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2 d-flex align-items-end mb-3">
                                                <button type="button" class="btn btn-danger delete-mtprima-btn" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        @foreach ($produccion->materiasPrimas as $index => $materiaPrima)
                                        <div class="row">
                                            <input type="hidden" name="id_registro[]" value="{{ $materiaPrima->pivot->id_registro }}">
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label for="produccion_mtPrima" class="bmd-label-floating">Materia Prima</label>
                                                    <select class="form-control border border-dark"
                                                        id="produccion_mtPrima{{$index}}" name="produccion_mtPrima[]"
                                                        required>
                                                        @foreach ($materiasPrimas1 as $materiaPrima1)
                                                        <option value="{{ $materiaPrima1->id_materia_prima }}"
                                                            @if ($materiaPrima1->id_materia_prima === $materiaPrima->id_materia_prima) selected @endif>
                                                            {{ $materiaPrima1->mat_pri_nombre }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label for="mtPrima_cantidad"
                                                        class="bmd-label-floating">Cantidad</label>
                                                    <input type="number"
                                                        class="form-control border border-dark"
                                                        name="mtPrima_cantidad[]" id="mtPrima_cantidad{{$index}}"
                                                        maxlength="50"
                                                        value="{{ $materiaPrima->pivot->reg_pmp_cantidad_usada }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger delete-mtprima-btn" 
                                                    data-id="{{ $materiaPrima->pivot->id_registro }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="col-12">
                                            <button type="button" class="btn btn-info mt-3 add-mtprima-btn">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <p class="text-center" style="margin-top: 40px;">
                                <button type="reset" class="btn btn-raised btn-secondary btn-sm">
                                    <i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
                                </button>
                                &nbsp; &nbsp;
                                <button type="submit" name="btn-produccion" value="editar"
                                    class="btn btn-raised btn-success btn-sm">
                                    <i class="far fa-save"></i> &nbsp; GUARDAR
                                </button>
                            </p>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Model Materias Primas -->
        @endforeach

        <!-- Modal-Ediciòn Tareas -->
        @foreach ($producciones as $produccion)
        <div class="modal fade" id="updateModalTareas{{ $produccion->id_produccion }}" tabindex="-1" role="dialog"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Gestionar Producción | {{ $produccion->id_produccion }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('update_tareas_api') }}"
                            method="POST" class="form-neon ajax-form" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_produccion" value="{{ $produccion->id_produccion }}">

                            <fieldset>
                                <legend><i class="fas fa-tasks"></i> &nbsp; Detalles de la Tarea</legend>
                                <div class="container-fluid">
                                    <div class="row tarea-container" id="tarea-container">
                                        {{-- Template para tarea (oculto) --}}
                                        <div class="row d-none">
                                            <div class="col-12 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <select class="form-control border border-dark produccion-tarea" name="tarea_id_tarea[]" >
                                                        @foreach ($todasTareas as $tareas)
                                                        <option value="{{ $tareas->id_tarea }}">
                                                            {{ $tareas->tar_nombre }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <select class="form-control border border-dark produccion-responsable" name="empleados_num_doc[]">
                                                        @foreach ($operarios as $operario)
                                                        <option value="{{ $operario->num_doc }}">
                                                            {{ $operario->usu_nombres }} {{ $operario->usu_apellidos }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-2">
                                                <div class="form-group">
                                                    <input type="date" class="form-control border border-dark produccion-fecha" name="emp_tar_fecha_entrega[]" >
                                                </div>
                                            </div>
                                        </div>

                                        @foreach ($produccion->tareas as $tarea)
                                        <input type="hidden" name="id_empleado_tarea[]"
                                            value="{{ $tarea->pivot->id_empleado_tarea }}">
                                        <div class="col-12 col-md-4 mb-2">
                                            <div class="form-group">
                                                <select class="form-control border border-dark"
                                                    id="produccion_tarea1" name="tarea_id_tarea[]"
                                                    required>
                                                    @foreach ($todasTareas as $tareas)
                                                    <option value="{{ $tareas->id_tarea }}"
                                                        @if ($tarea->id_tarea === $tareas->id_tarea) selected @endif>
                                                        {{ $tareas->tar_nombre }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-2" id="resp-container">
                                            <div class="form-group">
                                                <select class="form-control border border-dark produccion-responsable"
                                                    id="produccion_responsable1"
                                                    name="empleados_num_doc[]" required>
                                                    @foreach ($operarios as $operario)
                                                    <option value="{{ $operario->num_doc }}"
                                                        @if ($operario->num_doc === $tarea->pivot->empleados_num_doc) selected @endif>
                                                        {{ $operario->usu_nombres }}
                                                        {{ $operario->usu_apellidos }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-2" id="fEntrega-container">
                                            <div class="form-group">
                                                <input type="date"
                                                    class="form-control border border-dark produccion-fecha"
                                                    name="emp_tar_fecha_entrega[]"
                                                    id="produccion_fecha_entrega1"
                                                    value="{{ $tarea->pivot->emp_tar_fecha_entrega }}"
                                                    required>
                                            </div>
                                        </div>
                                        @endforeach

                                        <div class="col-12">
                                            <button type="button" id="addTareaBtn"
                                                class="btn btn-info mt-3 add-tarea-btn"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <p class="text-center" style="margin-top: 40px;">
                                <button type="reset" class="btn btn-raised btn-secondary btn-sm">
                                    <i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
                                </button>
                                &nbsp; &nbsp;
                                <button type="submit" name="btn-produccion" value="editar"
                                    class="btn btn-raised btn-success btn-sm">
                                    <i class="far fa-save"></i> &nbsp; GUARDAR
                                </button>
                            </p>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Model Tareas -->
        @endforeach

            </div>

            <div class="col-sm-6 col-md-6 col-lg-7">
                <div id="calendar"></div>
                <!-- Modal de Calendario - Producción -->
                <div class="modal fade" id="productionModal" tabindex="-1" role="dialog"
                    data-bs-backdrop="static">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Gestionar Producción:</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('nuevo-producto') }}" method="POST" class="form-neon" autocomplete="off">
                                    @csrf
                                    <fieldset>
                                        <legend><i class="fas fa-industry"></i> &nbsp; Información de la producción
                                        </legend>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="produccion_nombre"
                                                            class="bmd-label-floating">Nombre de la Producción</label>
                                                        <input type="text" class="form-control border border-dark"
                                                            name="produccion_nombre" id="produccion_nombre"
                                                            maxlength="50" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="produccion_fecha_inicio"
                                                            class="bmd-label-floating">Fecha de Inicio</label>
                                                        <input type="date" class="form-control border border-dark"
                                                            name="produccion_fecha_inicio" id="productionDate_inicio"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="productionDate_fin"
                                                            class="bmd-label-floating">Fecha de Finalización</label>
                                                        <input type="date" class="form-control border border-dark"
                                                            name="produccion_fecha_fin" id="productionDate_fin"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="produccion_cantidad"
                                                            class="bmd-label-floating">Cantidad de Producción</label>
                                                        <input type="number" class="form-control border border-dark"
                                                            name="produccion_cantidad" id="produccion_cantidad"
                                                            maxlength="50" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="produccion_etapa"
                                                            class="bmd-label-floating">Etapa</label>
                                                        <select class="form-control border border-dark"
                                                            id="produccion_etapa" name="produccion_etapa" required>
                                                            @foreach ($etapas as $etapa)
                                                            <option value="{{ $etapa->id_etapas }}">{{ $etapa->eta_nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <br><br>

                                    <fieldset>
                                        <legend><i class="fas fa-pallet fa-fw"></i> &nbsp; Detalles de Materia Prima
                                        </legend>
                                        <div class="container-fluid">
                                            <div class="row mt-3 mtprima-container" id="mtPrima-container">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="produccion_mtPrima"
                                                            class="bmd-label-floating">Materia Prima</label>
                                                        <select class="form-control border border-dark materia-prima-select"
                                                            id="produccion_mtPrima1" name="produccion_mtPrima[]"
                                                            required>
                                                            @foreach ($materiasPrimas1 as $materiaPrima)
                                                            <option value="{{ $materiaPrima->id_materia_prima }}">{{ $materiaPrima->mat_pri_nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="mtPrima_cantidad"
                                                            class="bmd-label-floating">Cantidad</label>
                                                        <input type="number" class="form-control border border-dark cantidad-input"
                                                            name="mtPrima_cantidad[]" id="mtPrima_cantidad1"
                                                            maxlength="50" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" id="addMtPrimaBtn"
                                                        class="btn btn-info mt-3 add-mtprima-btn">Agregar otra Materia Prima</button>
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>

                                    <br><br>

                                    <fieldset>
                                        <legend><i class="fas fa-tasks"></i> &nbsp; Detalles de la Tarea</legend>
                                        <div class="container-fluid">
                                            <div class="row tarea-container" id="tarea-container">
                                                <div class="col-12 col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <select class="form-control border border-dark produccion-tarea"
                                                            id="produccion_tarea1" name="produccion_tarea[]" required>
                                                            <option value="">Tarea</option>
                                                            @foreach ($todasTareas as $tarea)
                                                            <option value="{{ $tarea->id_tarea }}">{{ $tarea->tar_nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4" id="resp-container">
                                                    <div class="form-group">
                                                        <select class="form-control border border-dark produccion-responsable"
                                                            id="produccion_responsable1"
                                                            name="produccion_responsable[]" required>
                                                            <option value="">Responsable</option>
                                                            @foreach ($operarios as $operario)
                                                            <option value="{{ $operario->num_doc }}">{{ $operario->usu_nombres }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4" id="fEntrega-container">
                                                    <div class="form-group">
                                                        <input type="date" class="form-control border border-dark produccion-fecha"
                                                            name="produccion_fecha_entrega[]"
                                                            id="produccion_fecha_entrega1"
                                                            onfocus="(this.type='date')"
                                                            onblur="if(!this.value) this.type='text';"
                                                            placeholder="Fecha de Entrega" required>

                                                        <!-- <input type="date" class="form-control border border-dark" name="produccion_fecha_entrega" id="produccion_fecha_entrega1" onfocus="this.type='date'" onblur="this.type='text'" placeholder="Fecha de Entrega" required> -->
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" id="addTareaBtn"
                                                        class="btn btn-info mt-3 add-tarea-btn">Agregar otra tarea</button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <p class="text-center" style="margin-top: 40px;">
                                        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i
                                                class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                                        &nbsp; &nbsp;
                                        <button type="submit" name="btn-produccion" value="agregar"
                                            class="btn btn-raised btn-success btn-sm"><i class="far fa-save"></i>
                                            &nbsp; GUARDAR</button>
                                    </p>
                                </form>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Model Producción -->
            </div>
        </div>
    </div>
</x-app-layout>