<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registroForm">
        @csrf

        <!-- Estado y dirección ocultos -->
        <input type="hidden" name="usu_estado" value="1">
        <input type="hidden" name="usu_direccion" value="Bogotá">

        <div class="row">
            <div class="col-sm-6">
                <!-- Tipo de Documento -->
<<<<<<< HEAD
                <div  class="mt-4">
=======
                <div class="mt-4">
>>>>>>> main
                    <x-input-label for="t_doc" :value="__('Tipo de Documento')" />
                    <select id="t_doc" name="t_doc" class="block mt-1 w-full" required>
                        @foreach ($tiposDoc as $tipo)
                        <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->tip_doc_descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Número de Documento -->
                <div class="mt-4">
                    <x-input-label for="num_doc" :value="__('Número de Documento')" />
                    <x-text-input id="num_doc" class="block mt-1 w-full" type="number" name="num_doc" required />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- Nombres -->
                <div class="mt-4">
                    <x-input-label for="usu_nombres" :value="__('Nombres')" />
                    <x-text-input id="usu_nombres" class="block mt-1 w-full" type="text" name="usu_nombres" required />
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Apellidos -->
                <div class="mt-4">
                    <x-input-label for="usu_apellidos" :value="__('Apellidos')" />
                    <x-text-input id="usu_apellidos" class="block mt-1 w-full" type="text" name="usu_apellidos" required />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- Fecha de Nacimiento -->
                <div class="mt-4">
                    <x-input-label for="usu_fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="usu_fecha_nacimiento" class="block mt-1 w-full" type="date" name="usu_fecha_nacimiento" required />
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Sexo -->
                <div class="mt-4">
                    <x-input-label for="usu_sexo" :value="__('Sexo')" />
                    <select id="usu_sexo" name="usu_sexo" class="block mt-1 w-full" required>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
<<<<<<< HEAD
    <!-- Teléfono -->
    <div class="col-sm-6">
        <div class="mt-4">
            <x-input-label for="usu_telefono" :value="__('Teléfono')" />
            <x-text-input id="usu_telefono" class="block mt-1 w-full" type="text" name="usu_telefono"
                :value="old('usu_telefono')" required />
            <x-input-error :messages="$errors->get('usu_telefono')" class="mt-2" />
        </div>
    </div>

    <!-- Email -->
    <div class="col-sm-6">
        @if (!$user)
            <div class="mt-4">
                <x-input-label for="usu_email" :value="__('Correo Electrónico')" />
                <x-text-input id="usu_email" class="block mt-1 w-full" type="email" name="usu_email"
                    value="{{ old('usu_email', $user['email'] ?? '') }}" required autocomplete="username" />
                <x-input-error :messages="$errors->get('usu_email')" class="mt-2" />
            </div>
        @endif
    </div>
</div>

<div class="row">
    <!-- Contraseña -->
    @if (!$user)
    <div class="col-sm-6">
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
    </div>

    <!-- Confirmación de Contraseña -->
    <div class="col-sm-6">
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>
    @endif
</div>

<div class="flex items-center justify-end mt-4">
    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        href="{{ route('login') }}">
        {{ __('¿Ya estás registrado?') }}
    </a>

    <a class="ms-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        href="{{ route('login-google') }}">
        <i class="fa-brands fa-google"></i>mail
    </a>

    <x-primary-button class="ms-4">
        {{ __('Registrar') }}
    </x-primary-button>
</div>

=======
            <div class="col-sm-6">
                <!-- Teléfono -->
                <div class="mt-4">
                    <x-input-label for="usu_telefono" :value="__('Teléfono')" />
                    <x-text-input id="usu_telefono" class="block mt-1 w-full" type="number" name="usu_telefono" required />
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Correo Electrónico -->
                <div class="mt-4">
                    <x-input-label for="usu_email" :value="__('Correo Electrónico')" />
                    <x-text-input id="usu_email" class="block mt-1 w-full" type="email" name="usu_email" required />
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Contraseña -->
            <div class="col-sm-6">
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                </div>
            </div>

            <!-- Confirmación de Contraseña -->
            <div class="col-sm-6">
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4" id="btnRegistrar">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('btnRegistrar').addEventListener('click', function (event) {
            event.preventDefault();

            let num_doc = document.getElementById('num_doc').value.trim();
            let nombres = document.getElementById('usu_nombres').value.trim();
            let apellidos = document.getElementById('usu_apellidos').value.trim();
            let telefono = document.getElementById('usu_telefono').value.trim();
            let email = document.getElementById('usu_email').value.trim();
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('password_confirmation').value;

            let errores = [];

            if (!/^\d+$/.test(num_doc)) errores.push("El número de documento debe contener solo números.");
            if (!/^[a-zA-Z\s]+$/.test(nombres)) errores.push("Los nombres solo pueden contener letras y espacios.");
            if (!/^[a-zA-Z\s]+$/.test(apellidos)) errores.push("Los apellidos solo pueden contener letras y espacios.");
            if (!/^\d{10}$/.test(telefono)) errores.push("El teléfono debe tener numeros y exactamente 10 dígitos.");
            if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) errores.push("Correo electrónico inválido.");
            if (password.length < 8) errores.push("La contraseña debe tener al menos 8 caracteres.");
            if (password !== confirmPassword) errores.push("Las contraseñas no coinciden.");

            if (errores.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Errores en el formulario',
                    html: errores.join('<br>')
                });
            } else {
                document.getElementById('registroForm').submit();
            }
        });
    </script>
>>>>>>> main
</x-guest-layout>
