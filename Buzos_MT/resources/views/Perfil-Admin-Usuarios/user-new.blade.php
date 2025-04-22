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

        <form method="POST" action="{{ route('user-store') }}">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <input type="hidden" name="usu_estado" value="1"> <!-- O el valor adecuado para el estado -->

            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <x-input-label for="t_doc" :value="__('Tipo de Documento')" />
                            <select id="t_doc" name="t_doc" class="block mt-1 w-full" required>
                                @foreach ($tipos_documentos as $tipo)
                                <option value="{{ $tipo['id_tipo_documento'] }}">{{ $tipo['tip_doc_descripcion'] }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('t_doc')" class="mt-2" />
                        </div>

                        <div class="col-12 col-md-4">
                            <x-input-label for="num_doc" :value="__('Número de Documento')" />
                            <x-text-input id="num_doc" class="block mt-1 w-full" type="text" name="num_doc" :value="old('num_doc')"
                                required />
                            <x-input-error :messages="$errors->get('num_doc')" class="mt-2" />
                        </div>

                        <div class="col-12 col-md-4">
                            <x-input-label for="usu_nombres" :value="__('Nombres')" />
                            <x-text-input id="usu_nombres" class="block mt-1 w-full" type="text" name="usu_nombres" :value="old('usu_nombres')"
                                required />
                            <x-input-error :messages="$errors->get('usu_nombres')" class="mt-2" />
                        </div>

                        <div class="col-12 col-md-4">
                            <x-input-label for="usu_apellidos" :value="__('Apellidos')" />
                            <x-text-input id="usu_apellidos" class="block mt-1 w-full" type="text" name="usu_apellidos"
                                :value="old('usu_apellidos')" required />
                            <x-input-error :messages="$errors->get('usu_apellidos')" class="mt-2" />
                        </div>

                        <div class="col-12 col-md-4">
                            <x-input-label for="usu_fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                            <x-text-input id="usu_fecha_nacimiento" class="block mt-1 w-full" type="date" name="usu_fecha_nacimiento"
                                :value="old('usu_fecha_nacimiento')" required />
                            <x-input-error :messages="$errors->get('usu_fecha_nacimiento')" class="mt-2" />
                        </div>

                        <div class="col-12 col-md-4">
                            <x-input-label for="usu_sexo" :value="__('Sexo')" />
                            <select id="usu_sexo" name="usu_sexo" class="block mt-1 w-full" required>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                            </select>
                            <x-input-error :messages="$errors->get('usu_sexo')" class="mt-2" />
                        </div>


                        <div class="col-12 col-md-6">
                        <x-input-label for="usu_direccion" :value="__('Direccion')" />
                            <x-text-input id="usu_direccion" class="block mt-1 w-full" type="text" name="usu_direccion"
                                :value="old('usu_direccion')" required />
                            <x-input-error :messages="$errors->get('usu_direccion')" class="mt-2" />
                        </div>


                        <div class="col-12 col-md-6">
                            <x-input-label for="usu_telefono" :value="__('Teléfono')" />
                            <x-text-input id="usu_telefono" class="block mt-1 w-full" type="text" name="usu_telefono"
                                :value="old('usu_telefono')" required />
                            <x-input-error :messages="$errors->get('usu_telefono')" class="mt-2" />
                        </div>

                        <br><br><br>

                        <fieldset>
                            <legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
                            <div class="container-fluid">
                                <div class="row">

                                    <div class="col-12 col-md-6">
                                        <x-input-label for="email" :value="__('Correo Electrónico')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                            required autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <x-input-label for="password" :value="__('Contraseña')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                                            autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                            name="password_confirmation" required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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