<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

{{--     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("¡Ya has iniciado sesión!") }}
                </div>
            </div>
        </div>
    </div>
 --}}
    @php
        $perfil = auth()->user()->cargos()->first()->car_nombre ?? 'Sin Cargo';
    @endphp

    <!-- Card de Producción -->
    <div class="row">
        @if ($perfil === 'Jefe Producción')
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 tile-container">
                <a href="{{ route('produccion') }}" class="tile">
                    <div class="tile-tittle">Producción</div>
                    <div class="tile-icon">
                        <i class="fa-solid fa-industry"></i>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 tile-container">
                <a href="{{ route('pro_fabricados') }}" class="tile">
                    <div class="tile-tittle" style="line-height: 1.2;">Detalles de Producción</div>
                    <div class="tile-icon">
                        <i class="fa-solid fa-shirt"></i>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 tile-container">
                <a href="{{ route('pro_tareas') }}" class="tile">
                    <div class="tile-tittle">Tareas</div>
                    <div class="tile-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 tile-container">
                <a href="#" class="tile">
                    <div class="tile-tittle">Informes</div>
                    <div class="tile-icon">
                        <i class="fa-solid fa-file-circle-plus"></i>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 tile-container">
                <a href="{{ route('perfil-produccion.etapas') }}" class="tile">
                    <div class="tile-tittle">Etapas</div>
                    <div class="tile-icon">
                    <i class="fa-solid fa-route"></i>
                    </div>
                </a>
            </div>
        @endif
        
        @if ($perfil === 'Jefe Inventario')
            <div class="col-sm-12 col-md-4 tile-container">
                <a href="#" class="tile">
                    <div class="tile-tittle">Materia Prima</div>
                    <div class="tile-icon">
                        <i class="fas fa-pallet fa-fw"></i>
                    </div>
                </a>
            </div>
        @endif

         <!-- Card de administrador usuario -->
        @if ($perfil === 'Administrador Usuario')
            <div class="col-sm-12 col-md-4 tile-container">
                <a href="{{ route('user-list') }}" class="tile">
                    <div class="tile-tittle">Usuarios</div>
                    <div class="tile-icon">
                        <i class="fa-solid fa-user fa-fw"></i>
                    </div>
                </a>
            </div>

        @endif

        @if ($perfil === 'Operario')
            <div class="col-sm-12 col-md-4 tile-container">
                <a href="{{ route('tareas-asignadas')}}" class="tile">
                    <div class="tile-tittle">Mis Tareas</div>
                    <div class="tile-icon">
                        <i class="fa-brands fa-stack-exchange"></i>
                    </div>
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
