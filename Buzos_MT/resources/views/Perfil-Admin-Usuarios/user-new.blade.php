<x-app-layout>
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; NUEVO USUARIO
        </h3>
    </div>

    <div class="container-fluid">
        <ul class="full-box list-unstyled page-nav-tabs">
            <li><a class="active" href="{{ route('user-new') }}"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a></li>
            <li><a href="{{ route('user-list') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a></li>
            <li><a href="{{ route('user-search') }}"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a></li>
        </ul>
    </div>

    <div class="container-fluid">
        <!-- Mostrar mensaje de alerta si existe -->
        @if(session('alerta'))
        <div id="alerta" class="alert alert-info" role="alert" style="position: fixed; top: 20px; left: 20px; padding: 15px; border: 1px solid #12464c; border-radius: 8px; background-color: #12464c; color: white; z-index: 9999;">
            {{ session('alerta') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById("alerta").style.display = 'none';
            }, 4000);
        </script>
        @endif

        <form method="POST" action="{{ route('user-new') }}">
            @csrf

            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="tipo_documento" class="bmd-label-floating">Tipo documento</label>
                                <select class="form-control" name="tipoDocumento" id="tipo_documento">
                                    @foreach($tipos_documentos as $tipo)
                                    <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->tip_doc_descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_dni" class="bmd-label-floating">Numero de documento</label>
                                <input type="number" pattern="[0-9-]{1,20}" class="form-control" name="numeroDocumento" id="usuario_dni" maxlength="20">
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="nombres" id="usuario_nombre" maxlength="35">
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="apellidos" id="usuario_apellido" maxlength="35">
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="usu_fecha_nac" class="bmd-label-floating">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="fechaNacimiento" id="usu_fecha_nac">
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="sexo" class="bmd-label-floating">Sexo</label>
                                <select class="form-control" name="sexo" id="sexo">
                                    <option value="">Sexo</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
                                <input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,190}" class="form-control" name="direccion" id="usuario_direccion" maxlength="190">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
                                <input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="celular" id="usuario_telefono" maxlength="20">
                            </div>
                        </div>

                        <br><br><br>

                        <fieldset>
                            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="usu_fecha_contratacion" class="bmd-label-floating">Fecha contratación</label>
                                            <input type="date" class="form-control" name="fechaContratacion" id="usu_fecha_contratacion">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="usuario_email" class="bmd-label-floating">Email</label>
                                            <input type="email" class="form-control" name="correo" id="usuario_email" maxlength="70">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="usuario_clave_1" class="bmd-label-floating">Contraseña</label>
                                            <input type="password" class="form-control" name="password" id="usuario_clave_1" maxlength="200">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="usuario_clave_2" class="bmd-label-floating">Repetir contraseña</label>
                                            <input type="password" class="form-control" name="confirm_password" id="usuario_clave_2" maxlength="200">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>

            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
        </form>
    </div>
    </section>
    </main>
</x-app-layout>