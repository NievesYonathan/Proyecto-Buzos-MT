<x-app-layout>
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
        </h3>
    </div>

    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li>
                <a href="{{ route('user-new') }}"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
            </li>
            <li>
                <a class="active" href="{{ route('user-list') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
            </li>
            <li>
                <a href="{{ route('user-search') }}"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>TIPO DOCUMENTO</th>
                        <th>NUMERO DE DOCUMENTO</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>TELÉFONO</th>
                        <th>EMAIL</th>
                        <th>ESTADO</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr class="table-light text-center">
                        <td>{{ $usuario['tipo_documento']['tip_doc_descripcion'] }}</td>
                        <td>{{ $usuario['num_doc'] }}</td>
                        <td>{{ $usuario['usu_nombres'] }}</td>
                        <td>{{ $usuario['usu_apellidos'] }}</td>
                        <td>{{ $usuario['usu_telefono'] }}</td>
                        <td>{{ $usuario['email'] }}</td>
                        <td>{{ $usuario['estado']['nombre_estado'] }}</td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal{{ $usuario['num_doc'] }}">
                                <i class="fa-solid fa-user-pen"></i>
                            </button>
                        </td>
                        <td>
                            <form action="{{ route('user-cambiarestado', $usuario['num_doc']) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-danger" type="submit">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal para editar usuarios -->
                    <div class="modal fade" id="updateModal{{ $usuario['num_doc'] }}" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Modificar Usuario - {{ $usuario['num_doc'] }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('user-update', $usuario['num_doc']) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <fieldset>
                                            <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="tipo_documento" class="bmd-label-floating">Tipo documento</label>
                                                            <select class="form-select" aria-label="Default select example" id="t_doc" name="t_doc" required>
                                                                <option value="">Tipo de documento</option>
                                                                @foreach($tiposDocumentos as $tipo)
                                                                <option value="{{ $tipo['id_tipo_documento'] }}" @if($tipo['id_tipo_documento'] == $usuario['t_doc']) selected @endif>{{ $tipo['tip_doc_descripcion'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="usuario_dni" class="bmd-label-floating">Numero de documento</label>
                                                            <input type="number" pattern="[0-9-]{1,20}" class="form-control" name="num_doc" id="num_doc" value="{{ $usuario['num_doc'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
                                                            <input type="text" class="form-control" name="usu_nombres" id="usu_nombres" value="{{ $usuario['usu_nombres'] }}" maxlength="60">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
                                                            <input type="text" class="form-control" name="usu_apellidos" id="usu_apellidos" value="{{ $usuario['usu_apellidos'] }}" maxlength="40">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="usuario_fecha_nacimiento" class="bmd-label-floating">Fecha de nacimiento</label>
                                                            <input type="date" class="form-control" name="usu_fecha_nacimiento" id="usu_fecha_nacimiento"
                                                                value="{{ $usuario['usu_fecha_nacimiento'] ? \Carbon\Carbon::parse($usuario['usu_fecha_nacimiento'])->format('Y-m-d') : now()->format('Y-m-d') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_sexo" class="bmd-label-floating">sexo</label>
                                                            <input type="text" class="form-control" name="usu_sexo" id="usu_sexo" value="{{ $usuario['usu_sexo'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
                                                            <input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,190}" class="form-control" name="usuario_direccion" id="usuario_direccion" maxlength="190" value="{{ $usuario['usu_direccion'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
                                                            <input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usu_telefono" id="usu_telefono" maxlength="20" value="{{ $usuario['usu_telefono'] }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usu_fecha_contratacion" class="bmd-label-floating">Fecha de contratación</label>
                                                            <input type="date" class="form-control" name="usu_fecha_contratacion" id="usu_fecha_contratacion" maxlength="70"
                                                                value="{{ $usuario['usu_fecha_contratacion'] ? \Carbon\Carbon::parse($usuario['usu_fecha_contratacion'])->format('Y-m-d') : now()->format('Y-m-d') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="usuario_email" class="bmd-label-floating">Email</label>
                                                            <input type="email" class="form-control" name="email" id="email" value="{{ $usuario['email'] }}" maxlength="70">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <label for="usuario_estado" class="bmd-label-floating">Estado</label>
                                                        <select class="form-select" aria-label="Default select example" id="usu_estado" name="usu_estado" required>
                                                            @foreach($estados as $estado)
                                                            @if ($estado['nombre_estado'] == 'Activo' || $estado['nombre_estado'] == 'Inactivo')
                                                            <option value="{{ $estado['id_estados'] }}" {{ $estado['id_estados'] == $usuario['usu_estado'] ? 'selected' : '' }}>
                                                                {{ $estado['nombre_estado'] }}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</x-app-layout>