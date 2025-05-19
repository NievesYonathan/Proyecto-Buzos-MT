<x-app-layout>
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR CARGOS
        </h3>
    </div>

    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a class="active" href="{{ route('cargos') }}"><i class="fas fa-plus fa-fw"></i> &nbsp; CARGOS</a>
            </li>
            <li>
                <a href="{{ route('user-list-cargo') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="container-fluid">
        <form action="{{ route('cargos.store') }}" method="POST" class="form-neon" autocomplete="off">
            @csrf
            <fieldset>
                <legend><i class="fas fa-user-lock"></i> &nbsp; Registrar Cargos del Sistema</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="cargo_sistema" class="bmd-label-floating">Nombre del Cargo</label>
                                <input type="text" class="form-control" name="car_nombre" id="cargo_sistema">
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

        <div class="form-neon mt-20">
            <legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de Cargos del Sistema</legend>
            <!-- Elimina el punto de la lista -->
            <style>
                ul {
                    list-style-type: none;
                }
            </style>
            <ul>
                @foreach ($cargos as $cargo)
                    <li>
                        <i class="fas fa-check-circle"></i> {{ $cargo['car_nombre'] }} 
                        <button data-bs-toggle="modal" data-bs-target="#updateModal{{ $cargo['id_cargos'] }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    </li>

                    <!-- Modal para editar usuarios -->
                    <div class="modal fade" id="updateModal{{ $cargo['id_cargos'] }}" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('cargos.update', $cargo ['id_cargos']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <fieldset>
                                            <legend><i class="far fa-address-card"></i> &nbsp; Editar Cargo</legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="car_nombre" class="bmd-label-floating">Nombre</label>
                                                            <input type="text" class="form-control" name="car_nombre" id="car_nombre" value="{{ $cargo['car_nombre'] }}" maxlength="60">
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
