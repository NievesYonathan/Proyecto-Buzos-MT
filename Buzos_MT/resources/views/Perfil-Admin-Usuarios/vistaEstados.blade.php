<x-app-layout>
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR ESTADOS
        </h3>
    </div>

    <!-- Content -->
    <div class="container-fluid">
        <form action="{{ route('estados.store') }}" method="POST" class="form-neon" autocomplete="off">
            @csrf
            <fieldset>
                <legend><i class="fas fa-user-lock"></i> &nbsp; Registrar Estados</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="nombreEst" class="bmd-label-floating">Ingrese el tipo de estado</label>
                                <input type="text" class="form-control" name="nombre_estado" id="nombreEst">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm">
                    <i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
                </button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm">
                    <i class="far fa-save"></i> &nbsp; GUARDAR
                </button>
            </p>
        </form>

        <br>

        <div class="form-neon mt-20">
            <legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de Estados</legend>
            <style>
                ul {
                    list-style-type: none;
                }
            </style>
            <ul>
                @foreach ($estados as $estado)
                    <li class="mb-2">
                        <i class="fas fa-check-circle"></i> {{ $estado['nombre_estado'] }}
                        <button data-bs-toggle="modal" data-bs-target="#updateModal{{ $estado['id_estados'] }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    </li>

                    <!-- Modal para editar usuarios -->
                    <div class="modal fade" id="updateModal{{ $estado['id_estados'] }}" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('estados.update', $estado['id_estados']) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $estado['id_estados'] }}">
                                        <fieldset>
                                            <legend><i class="far fa-address-card"></i> &nbsp; Editar Cargo</legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombreEst" class="bmd-label-floating">Nombre</label>
                                                            <input type="text" class="form-control" name="nombre_estado" id="nombreEst" value="{{ $estado['nombre_estado'] }}" maxlength="60">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="submit">Actualizar</button>
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
