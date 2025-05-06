<x-app-layout>
    <div class="mt-5">
        <form action="{{ route('perfil-produccion.etapas.store') }}" method="POST" class="form-neon" autocomplete="off">
            @csrf
            <fieldset>
                <legend><i class="fas fa-layer-group"></i> &nbsp; Registrar nueva etapa</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6"> <!-- Nombre de la etapa -->
                            <div class="form-group">
                                <label for="eta_nombre" class="bmd-label-floating">Nombre de la etapa</label>
                                <input type="text" class="form-control" name="eta_nombre" id="eta_nombre" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6"> <!-- Descripción de la etapa -->
                            <div class="form-group">
                                <label for="eta_descripcion" class="bmd-label-floating">Descripción</label>
                                <textarea class="form-control" name="eta_descripcion" id="eta_descripcion" rows="3" required></textarea>
                            </div>
                        </div>
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
            <legend><i class="fa-regular fa-layer-group"></i> &nbsp; Lista de etapas</legend>
            <!-- Elimina el punto de la lista -->
            <style>
                ul {
                    list-style-type: none;
                }
            </style>
            <ul>
                @foreach ($etapas as $etapa)
                <li class="mb-2" id="etapa-{{ $etapa->id_etapas }}">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-layer-group"></i> {{ $etapa->eta_nombre }}
                        </div>
                        <div class="col-6">
                            <!-- Botón de actualizar -->
                            <button data-bs-toggle="modal" data-bs-target="#updateModal{{ $etapa->id_etapas }}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <!-- Botón de eliminar -->
                            <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $etapa->id_etapas }}">
                                <i class="fas fa-trash-alt text-dark"></i>
                            </button>
                        </div>
                    </div>
                </li>

                <!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal{{ $etapa->id_etapas }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $etapa->id_etapas }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $etapa->id_etapas }}">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta etapa?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                <!-- Formulario de eliminación -->
                <form action="{{ route('perfil-produccion.etapas.destroy', $etapa->id_etapas) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
                <!-- Modal para editar etapas -->
                <div class="modal fade" id="updateModal{{ $etapa->id_etapas }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('perfil-produccion.etapas.update', $etapa->id_etapas)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $etapa->id_etapas }}">
                                    <fieldset>
                                        <legend><i class="far fa-edit"></i> &nbsp; Editar etapa</legend>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <!-- Campo para nombre de la etapa -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="eta_nombre" class="bmd-label-floating">Nombre de la etapa</label>
                                                        <input type="text" class="form-control" name="eta_nombre" id="eta_nombre" value="{{ $etapa->eta_nombre }}" maxlength="60">
                                                    </div>
                                                </div>

                                                <!-- Campo para descripción de la etapa -->
                                                <div class="col-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="eta_descripcion" class="bmd-label-floating">Descripción</label>
                                                        <textarea class="form-control" name="eta_descripcion" id="eta_descripcion" rows="3">{{ $etapa->eta_descripcion }}</textarea>
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
