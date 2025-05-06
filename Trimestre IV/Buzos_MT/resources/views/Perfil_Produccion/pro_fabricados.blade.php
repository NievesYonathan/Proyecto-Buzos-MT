<x-app-layout>
    <div class="my-5">
        <div class="row">
            @foreach ($producciones as $produccion)
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 mb-5">
                <div class="card">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $produccion->pro_img) }}" alt="Producto">
                        <div class="price">Cantidad: {{ $produccion->pro_cantidad }}</div>
                    </div><br>
                    <div class="content">
                        <h3 class="product-name">{{ $produccion->pro_nombre }}</h3>
                        <p class="product-dates">
                            Inicio: {{ $produccion->pro_fecha_inicio->format('Y-m-d') }} <br>
                            Fin: {{ $produccion->pro_fecha_fin->format('Y-m-d') }}
                        </p>
                        <p class="product-status">
                            Etapa: {{ $produccion->etapa->eta_nombre }}
                        </p>
                        @foreach ($produccion->regProFabricados as $registro)
                        <p class="product-material">Material: {{ $registro->reg_pf_material }}</p>
                        @endforeach
                        <div class="button-container">
                            <button class="button buy-button" data-bs-toggle="modal"
                                data-bs-target="#selectionModal{{ $produccion->id_produccion }}">Editar</button>
                        </div>
                    </div>
                </div>
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
                                                    name="produccion_fecha_inicio" id="productionDate"
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
</x-app-layout>
