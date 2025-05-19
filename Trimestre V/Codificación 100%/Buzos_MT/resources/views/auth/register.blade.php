<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registroForm">
        @csrf

        <!-- Estado y dirección ocultos -->
        <input type="hidden" name="usu_estado" value="1">
        <input type="hidden" name="usu_direccion" value="Bogotá">

        <div class="row">
            <div class="col-sm-6">
                <!-- Tipo de Documento -->
                <div class="mt-4">
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
                    <div class="error-message" id="error-num_doc" style="display: none; color: red; font-size: 0.875rem;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- Nombres -->
                <div class="mt-4">
                    <x-input-label for="usu_nombres" :value="__('Nombres')" />
                    <x-text-input id="usu_nombres" class="block mt-1 w-full" type="text" name="usu_nombres" required />
                    <div class="error-message" id="error-usu_nombres" style="display: none; color: red; font-size: 0.875rem;"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Apellidos -->
                <div class="mt-4">
                    <x-input-label for="usu_apellidos" :value="__('Apellidos')" />
                    <x-text-input id="usu_apellidos" class="block mt-1 w-full" type="text" name="usu_apellidos" required />
                    <div class="error-message" id="error-usu_apellidos" style="display: none; color: red; font-size: 0.875rem;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- Fecha de Nacimiento -->
                <div class="mt-4">
                    <x-input-label for="usu_fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="usu_fecha_nacimiento" class="block mt-1 w-full" type="date" name="usu_fecha_nacimiento" required />
                    <div class="error-message" id="error-usu_fecha_nacimiento" style="display: none; color: red; font-size: 0.875rem;"></div>
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
            <div class="col-sm-6">
                <!-- Teléfono -->
                <div class="mt-4">
                    <x-input-label for="usu_telefono" :value="__('Teléfono')" />
                    <x-text-input id="usu_telefono" class="block mt-1 w-full" type="number" name="usu_telefono" required />
                    <div class="error-message" id="error-usu_telefono" style="display: none; color: red; font-size: 0.875rem;"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Correo Electrónico -->
                <div class="mt-4">
                    <x-input-label for="usu_email" :value="__('Correo Electrónico')" />
                    <x-text-input id="usu_email" class="block mt-1 w-full" type="email" name="usu_email" required />
                    <div class="error-message" id="error-usu_email" style="display: none; color: red; font-size: 0.875rem;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Contraseña -->
            <div class="col-sm-6">
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <div class="error-message" id="error-password" style="display: none; color: red; font-size: 0.875rem;"></div>
                </div>
            </div>

            <!-- Confirmación de Contraseña -->
            <div class="col-sm-6">
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    <div class="error-message" id="error-password_confirmation" style="display: none; color: red; font-size: 0.875rem;"></div>
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

        // Limpiar errores previos
        let errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(el => el.style.display = 'none');
        let inputElements = document.querySelectorAll('input, select');
        inputElements.forEach(el => el.classList.remove('border-red-500'));

        // Obtener valores de campos
        let num_doc = document.getElementById('num_doc').value.trim();
        let nombres = document.getElementById('usu_nombres').value.trim();
        let apellidos = document.getElementById('usu_apellidos').value.trim();
        let telefono = document.getElementById('usu_telefono').value.trim();
        let email = document.getElementById('usu_email').value.trim();
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('password_confirmation').value;
        let fecha_nacimiento = document.getElementById('usu_fecha_nacimiento').value;

        let errores = [];

        if (!/^\d+$/.test(num_doc)) {
            errores.push("El número de documento debe contener solo números.");
            document.getElementById('error-num_doc').innerText = "El número de documento debe contener solo números.";
            document.getElementById('error-num_doc').style.display = 'block';
            document.getElementById('num_doc').classList.add('border-red-500');
        }

        if (!/^[a-zA-Z\s]+$/.test(nombres)) {
            errores.push("Los nombres solo pueden contener letras y espacios.");
            document.getElementById('error-usu_nombres').innerText = "Los nombres solo pueden contener letras y espacios.";
            document.getElementById('error-usu_nombres').style.display = 'block';
            document.getElementById('usu_nombres').classList.add('border-red-500');
        }

        if (!/^[a-zA-Z\s]+$/.test(apellidos)) {
            errores.push("Los apellidos solo pueden contener letras y espacios.");
            document.getElementById('error-usu_apellidos').innerText = "Los apellidos solo pueden contener letras y espacios.";
            document.getElementById('error-usu_apellidos').style.display = 'block';
            document.getElementById('usu_apellidos').classList.add('border-red-500');
        }

        if (!/^\d{10}$/.test(telefono)) {
            errores.push("El teléfono debe tener exactamente 10 dígitos.");
            document.getElementById('error-usu_telefono').innerText = "El teléfono debe tener exactamente 10 dígitos.";
            document.getElementById('error-usu_telefono').style.display = 'block';
            document.getElementById('usu_telefono').classList.add('border-red-500');
        }

        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
            errores.push("Correo electrónico inválido.");
            document.getElementById('error-usu_email').innerText = "Correo electrónico inválido.";
            document.getElementById('error-usu_email').style.display = 'block';
            document.getElementById('usu_email').classList.add('border-red-500');
        }

        if (password.length < 8) {
            errores.push("La contraseña debe tener al menos 8 caracteres.");
            document.getElementById('error-password').innerText = "La contraseña debe tener al menos 8 caracteres.";
            document.getElementById('error-password').style.display = 'block';
            document.getElementById('password').classList.add('border-red-500');
        }

        if (password !== confirmPassword) {
            errores.push("Las contraseñas no coinciden.");
            document.getElementById('error-password_confirmation').innerText = "Las contraseñas no coinciden.";
            document.getElementById('error-password_confirmation').style.display = 'block';
            document.getElementById('password_confirmation').classList.add('border-red-500');
        }

        if (!fecha_nacimiento) {
            errores.push("La fecha de nacimiento es requerida.");
            document.getElementById('error-usu_fecha_nacimiento').innerText = "La fecha de nacimiento es requerida.";
            document.getElementById('error-usu_fecha_nacimiento').style.display = 'block';
            document.getElementById('usu_fecha_nacimiento').classList.add('border-red-500');
        }

        // Si no hay errores, se envía el formulario
        if (errores.length === 0) {
            document.getElementById('registroForm').submit();
        }
    });
</script>

</x-guest-layout>
