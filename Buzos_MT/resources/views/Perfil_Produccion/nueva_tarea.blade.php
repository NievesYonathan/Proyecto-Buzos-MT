<x-app-layout>
    <div class="mt-5">
        <form action="{{ route('nueva_tarea') }}" method="POST" class="form-neon" autocomplete="off">
            @csrf
            <fieldset>
                <legend><i class="fas fa-user-lock"></i> &nbsp; Registrar nueva tarea</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6"> <!-- Nombre de la tarea -->
                            <div class="form-group">
                                <label for="tar_nombre" class="bmd-label-floating">Nombre de la tarea</label>
                                <input type="text" class="form-control" name="tar_nombre" id="tarea_sistema" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6"> <!-- Descripción de la tarea -->
                            <div class="form-group">
                                <label for="tar_descripcion" class="bmd-label-floating">Descripción</label>
                                <textarea class="form-control" name="tar_descripcion" id="descripcion" rows="3" required></textarea>
                            </div>
                        </div>
                        <!-- <div class="col-12 col-md-6"> 
                        <div class="form-group">
                            <label for="estado" class="bmd-label-floating">Estado</label>
                            <select name="estado" id="estado" class="form-control" required>
                                <option value="" disabled selected>Seleccione un estado</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div> -->
                    </div>
                </div>
            </fieldset>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
        </form>

        <br>

        <div class="form-neon">
            <legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de tareas</legend>
            <!-- Elimina el punto de la lista -->
            <style>
                ul {
                    list-style-type: none;
                }
            </style>
            <ul>
                @foreach ($tareas as $tarea)
                <li class="mb-2">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-check-circle"></i> {{ $tarea['tar_nombre'] }}
                        </div>
                        <div class="col-6">
                            <button data-bs-toggle="modal" data-bs-target="#updateModal{{ $tarea['id_tarea'] }}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </div>
                    </div>
                </li>
                <!-- Modal para editar usuarios -->
                <div class="modal fade" id="updateModal{{ $tarea['id_tarea'] }}" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('update_tarea', $tarea['id_tarea'])}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $tarea['id_tarea'] }}">
                                    <fieldset>
                                        <legend><i class="far fa-address-card"></i> &nbsp; Editar tarea</legend>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <!-- Campo para nombre -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="usuario_nombre" class="bmd-label-floating">Nombre</label>
                                                        <input type="text" class="form-control" name="tar_nombre" id="usuario_nombre" value="{{ $tarea['tar_nombre'] ?? '' }}" maxlength="60">
                                                    </div>
                                                </div>

                                                <!-- Campo para descripción -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="descripcion" class="bmd-label-floating">Descripción</label>
                                                        <textarea class="form-control" name="tar_descripcion" id="descripcion" rows="3">{{ $tarea['tar_descripcion'] }}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Campo para estado -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="estado" class="bmd-label-floating">Estado</label>
                                                        <select class="form-control" name="tar_estado" id="estado">
                                                            @foreach ($estados as $estado)
                                                            @if ($estado['nombre_estado'] === 'Activo' || $estado['nombre_estado'] === 'Inactivo')
                                                            <option value="{{ $estado['id_estados'] }}"
                                                                @if (isset($tarea->estados['id_estados']) && $estado->id_estados === $tarea->estados['id_estados']) selected @endif>
                                                                {{ $estado['nombre_estado'] }}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit" name="Accion" value="Actualizar">Actualizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>