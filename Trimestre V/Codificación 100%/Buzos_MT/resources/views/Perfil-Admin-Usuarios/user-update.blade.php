<x-app-layout>
    <main class="full-box main-container">
        <!-- Nav lateral -->
        @include('componentes.sidebar')

        <!-- Page content -->
        <section class="full-box page-content">
            <!-- Navbar -->
            @include('componentes.navbar')

            <div class="full-box page-header">
                <h3 class="text-left"><i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR DATOS</h3>
            </div>

            <div class="container-fluid">
                <form method="POST" action="{{ route('usuario.actualizar') }}" id="formActualizarUsuario">
                    @csrf
                    <fieldset>
                        <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_documento">Tipo documento:</label>
                                        <select class="form-select" id="tipoDocumento" name="tipoDocumento" disabled>
                                            @foreach($tiposDocumento as $tipo)
                                                <option value="{{ $tipo->id }}" {{ $tipo->id == $usuario->t_doc ? 'selected' : '' }}>
                                                    {{ $tipo->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_dni">Número de documento:</label>
                                        <input type="text" class="form-control" name="usuario_dni" id="usuario_dni" value="{{ $usuario->num_doc }}" readonly>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_nombre">Nombres:</label>
                                        <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="{{ $usuario->nombres }}" maxlength="35">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_apellido">Apellidos:</label>
                                        <input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido" value="{{ $usuario->apellidos }}" maxlength="35">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_telefono">Teléfono:</label>
                                        <input type="text" class="form-control" name="usuario_telefono" id="usuario_telefono" value="{{ $usuario->telefono }}" maxlength="15">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_email">Email:</label>
                                        <input type="email" class="form-control" name="usuario_email" id="usuario_email" value="{{ $usuario->email }}" maxlength="70">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="usuario_sexo">Sexo:</label>
                                        <input type="text" class="form-control" name="usuario_sexo" id="usuario_sexo" value="{{ $usuario->sexo }}" maxlength="70">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <br>

                    <fieldset>
                        <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="password">Nueva Contraseña (dejar en blanco si no desea cambiarla):</label>
                                        <input type="password" class="form-control" name="password" id="password" minlength="8">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirmar Nueva Contraseña:</label>
                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" minlength="8">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-success btn-sm">
                            <i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR
                        </button>
                    </p>
                </form>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('formActualizarUsuario').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</x-app-layout>
