<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- En tu formulario de registro -->
        <input type="hidden" name="usu_estado" value="1"> <!-- O el valor adecuado para el estado -->
        <input type="hidden" name="usu_direccion" value="Bogotá"> <!-- O el valor adecuado para el estado -->
        @if($user)
        <input type="hidden" name="external_id" value="{{}}">
        @endif

        <!-- Tipo de Documento -->
        <div>
            <x-input-label for="t_doc" :value="__('Tipo de Documento')" />
            <select id="t_doc" name="t_doc" class="block mt-1 w-full" required>
                @foreach ($tiposDoc as $tipo)
                <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->tip_doc_descripcion }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('t_doc')" class="mt-2" />
        </div>

        <!-- Número de Documento -->
        <div class="mt-4">
            <x-input-label for="num_doc" :value="__('Número de Documento')" />
            <x-text-input id="num_doc" class="block mt-1 w-full" type="text" name="num_doc" :value="old('num_doc')"
                required />
            <x-input-error :messages="$errors->get('num_doc')" class="mt-2" />
        </div>

        <!-- Nombres -->
        <div class="mt-4">
            <x-input-label for="usu_nombres" :value="__('Nombres')" />
            <x-text-input id="usu_nombres" class="block mt-1 w-full" type="text" name="usu_nombres" value="{{ old('usu_nombres', $user['name'] ?? '') }}"
                required />
            <x-input-error :messages="$errors->get('usu_nombres')" class="mt-2" />
        </div>

        @if (!$user)
        <!-- Apellidos -->
        <div class="mt-4">
            <x-input-label for="usu_apellidos" :value="__('Apellidos')" />
            <x-text-input id="usu_apellidos" class="block mt-1 w-full" type="text" name="usu_apellidos"
                value="{{ old('usu_apellidos') }}" required />
            <x-input-error :messages="$errors->get('usu_apellidos')" class="mt-2" />
        </div>
        @endif

        <!-- Fecha de Nacimiento -->
        <div class="mt-4">
            <x-input-label for="usu_fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
            <x-text-input id="usu_fecha_nacimiento" class="block mt-1 w-full" type="date" name="usu_fecha_nacimiento"
                :value="old('usu_fecha_nacimiento')" required />
            <x-input-error :messages="$errors->get('usu_fecha_nacimiento')" class="mt-2" />
        </div>

        <!-- Sexo -->
        <div class="mt-4">
            <x-input-label for="usu_sexo" :value="__('Sexo')" />
            <select id="usu_sexo" name="usu_sexo" class="block mt-1 w-full" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
            </select>
            <x-input-error :messages="$errors->get('usu_sexo')" class="mt-2" />
        </div>

        <!-- Teléfono -->
        <div class="mt-4">
            <x-input-label for="usu_telefono" :value="__('Teléfono')" />
            <x-text-input id="usu_telefono" class="block mt-1 w-full" type="text" name="usu_telefono"
                :value="old('usu_telefono')" required />
            <x-input-error :messages="$errors->get('usu_telefono')" class="mt-2" />
        </div>

        @if ($user)
        <input type="hidden" name="usu_email" value="{{$user['email']}}">
        @endif

        @if (!$user)
        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="usu_email" :value="__('Correo Electrónico')" />
            <x-text-input id="usu_email" class="block mt-1 w-full" type="email" name="usu_email" value="{{ old('usu_email', $user['email'] ?? '') }}"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('usu_email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmación de Contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>