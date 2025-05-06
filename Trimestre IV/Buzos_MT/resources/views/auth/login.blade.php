<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Tipo de Documento -->
        <div>
            <x-input-label for="t_doc" :value="__('Tipo de Documento')" />
            <select id="t_doc" name="t_doc" class="block mt-1 w-full" required>
                <option value="" disabled selected>{{ __('Selecciona un tipo de documento') }}</option>
                @foreach ($tiposDoc as $tipo)
                <option value="{{ $tipo->id_tipo_documento }}">{{ $tipo->tip_doc_descripcion }}</option> <!-- Ajusta 'id' y 'nombre' según tu tabla -->
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('t_doc')" class="mt-2" />
        </div>

        <!-- Número de Documento -->
        <div class="mt-4">
            <x-input-label for="num_doc" :value="__('Número de Documento')" />
            <x-text-input id="num_doc" class="block mt-1 w-full" type="text" name="num_doc" :value="old('num_doc')" required autofocus autocomplete="num_doc" />
            <x-input-error :messages="$errors->get('num_doc')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Recordarme -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login-google') }}">{{ __('Google') }}</a>

            @if (Route::has('password.request'))
            <a class="ms-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                {{ __('¿Olvidaste tu contraseña?') }}
            </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>