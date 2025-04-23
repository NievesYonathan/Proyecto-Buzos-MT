<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-content">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary" id="btn-reversa">
            <i class="fa fa-arrow-left"></i>
        </a>

        @php
        $name = auth()->user()->usu_nombres;
        $perfil = auth()->user()->cargos()->first()->car_nombre ?? 'Sin Cargo';

        @endphp

        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle show-nav-lateral"></i>
            <img src="{{ asset('storage/' . Auth::user()->imag_perfil) }}" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-name">
                {{ $name }} <br><small class="roboto-condensed-light">{{ $perfil }}</small>
            </figcaption>
        </figure>

        <div class="full-box nav-lateral-bar"></div> <!-- Barra roja de división -->

        <nav class="full-box nav-lateral-menu">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
                </li>

                @if($perfil === 'Jefe Inventario')
                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-pallet fa-fw"></i> &nbsp; Materia Prima <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li><a href="{{ route('vistaForm')}}"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar item</a></li>
                        <li><a href=" {{ route('lista-item')}}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de items</a></li>
                        <li><a href="{{ route('buscar-producto')}}"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar item</a></li>
                        <li><a href="{{ route('reportes')}}"><i class="fa-regular fa-file"></i> &nbsp; Reportes</a></li>
                        <!-- <li><a href="#"><i class="fa-solid fa-info-circle"></i> &nbsp; Detalles item</a></li>
                        <li><a href="#"><i class="fa-solid fa-clock-rotate-left"></i> &nbsp; Historial</a></li>
                        <li><a href="#"><i class="fa-solid fa-pen-to-square"></i> &nbsp; Actualizar</a></li> -->
                    </ul>
                </li>
                @endif

                @if($perfil === 'Administrador Usuario')
                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fa-solid fa-user fa-fw"></i> &nbsp; Usuarios <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li><a href="{{ route('user-new') }}"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo usuario</a></li>
                        <li><a href="{{ route('user-list') }}"><i class="fa-solid fa-user-tie"></i> &nbsp; Empleados</a></li>
                        <li><a href="{{ route('user-search') }}"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar usuario</a></li>
                        <li><a href="{{ route('tipoDocumentos') }}"><i class="fa-brands fa-dochub"></i> &nbsp; Tipos de Documentos</a></li>
                        <li><a href="{{ route('vistaEstados') }}"><i class="fa-solid fa-e"></i> &nbsp; Estados</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('cargos') }}"><i class="fa-solid fa-address-book"></i> &nbsp; Cargos </a></li>
                <li><a href="{{ route('informe-RRHH') }}"><i class="fa-solid fa-users"></i> &nbsp; RR.HH </a></li>
                @endif

                @if($perfil === 'Jefe Producción')
                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fa-solid fa-industry"></i> &nbsp; Producción <i class="fas fa-chevron-down"></i></a>
                    <ul>
                        <li><a href="{{ route('produccion') }}"><i class="fa-solid fa-industry"></i> &nbsp; Gestion de Producción</a></li>
                        <li><a href="{{ route('pro_fabricados') }}" style="font-size: 13px"><i class="fa-solid fa-shirt"></i> &nbsp; Gestion Productos Fabricados</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('pro_tareas') }}"><i class="fa-solid fa-calendar-days"></i> &nbsp; Tareas </a></li>
                <li>
                    <a href="{{ route('perfil-produccion.etapas') }}"><i class="fa-solid fa-route"></i> &nbsp; Etapas</a>
                </li>
                @endif

                <!-- Agrega más secciones para otros perfiles como 'Jefe Producción' y 'Operario' según tu lógica -->

            <!-- Boton para q el operario vea sus tareas -->
                @if($perfil === 'Operario')
                <li><a href="{{ route('tareas-asignadas') }}"><i class="fa-solid fa-calendar-days"></i> &nbsp; Mis Tareas</a></li>
                @endif

                <li><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-gear"></i> &nbsp; Configuración</a></li>
            </ul>
        </nav>
    </div>
</section>