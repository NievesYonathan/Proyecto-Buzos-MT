<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Actualiza la información de perfil y la dirección de correo electrónico de tu cuenta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulario para la información del perfil -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" /><!-- estaba en 'name', verificar q no genere conflicto -->
            <x-text-input id="name" name="usu_nombres" type="text" class="mt-1 block w-full" :value="old('usu_nombres', $user->usu_nombres)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo')" /><!-- estaba en 'Email', verificar q no genere conflicto -->
            <x-text-input id="email" name="usu_email" type="email" class="mt-1 block w-full" :value="old('usu_email', $user->usu_email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Haz clic aquí para reenviar el correo electrónico de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Actualizado.') }}</p>
            @endif
        </div>
    </form>

    <!-- Formulario para la imagen de perfil -->
    <form method="post" action="{{ route('storeImage', $name = auth()->user()->num_doc) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        
        <div>
            <x-input-label for="imag_perfil" :value="__('Imagen de Perfil')" />
            <div class="mt-1 mb-2">
                @if ($user->imag_perfil)
                @php
                $name = auth()->user()->usu_nombres;
                $perfil = auth()->user()->cargos()->first()->car_nombre;
        
                $external_id = auth()->user()->external_id;
        
                if ($external_id) {
                    $img_route = Auth::user()->imag_perfil;
                } else {
                    $img_route = 'storage/' . Auth::user()->imag_perfil;
                }
                @endphp
        
                <img src="{{ asset($img_route) }}" alt="Profile Image" class="img-user w-48 h-36 object-cover">

                @else
                    <p>{{ __('No se ha cargado ninguna imagen de perfil.') }}</p>
                @endif
            </div>
            <x-input-label for="imag_perfil" :value="__('Subir Nueva Imagen de Perfil')" />
            <x-text-input id="imag_perfil" name="imag_perfil" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('imag_perfil')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Subir Imagen') }}</x-primary-button>
        </div>
    </form>
</section>
