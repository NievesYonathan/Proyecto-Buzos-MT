<x-app-layout>
    <div class="container mt-5">
        <div class="table-overflow">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>#</th>
                        <th>Nombre de la Tarea</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha de Asignación</th>
                        <th>Fecha de Entrega</th>
                        <th>Actualizar Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($tareasAsignadas))
                    <tr>
                        <td colspan="7" class="text-center">No hay tareas asignadas.</td>
                    </tr>
                    @else
                    @foreach ($tareasAsignadas as $tareas)
                    @foreach ($tareas['empleados'] as $empleado)
                    <tr class="table-light text-center">
                        <td>{{ $tareas['id_tarea'] }}</td>
                        <td>{{ $tareas['tar_nombre'] }}</td>
                        <td>{{ $tareas['tar_descripcion'] }}</td>
                        @php
                        $estadoCorrespondiente = collect($estados)->firstWhere('id_estados', $empleado['pivot']['emp_tar_estado_tarea']);
                        @endphp
                        <td>{{ $estadoCorrespondiente ? $estadoCorrespondiente['nombre_estado'] : 'Estado no encontrado' }}</td>
                        <td>{{ $empleado['pivot']['emp_tar_fecha_asignacion'] }}</td>
                        <td>{{ $empleado['pivot']['emp_tar_fecha_entrega'] }}</td>
                        <td>
                            <a href="{{ route('tarea.editar', ['id_tarea' => $tareas['id_tarea'], 'id_empleado_tarea' => $empleado['pivot']['id_empleado_tarea']]) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>