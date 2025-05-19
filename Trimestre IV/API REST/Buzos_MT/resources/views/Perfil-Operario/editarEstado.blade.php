<x-app-layout>
    <div class="container mt-5">
        <!-- Verificar si hay un mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h3>Actualizar Estado de Tarea: {{ $tarea['tar_nombre'] }}</h3>

        <form method="POST" action="{{ route('tarea.actualizarEstado', ['id_tarea' => $tarea['id_tarea'], 'id_empleado_tarea' => $empleadoTarea['id_empleado_tarea']]) }}">
            @csrf
            @method('POST')
            <div class="form-group mb-3">
                <label for="estadoTarea">Estado</label>
                <select class="form-control" name="estadoTarea" required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado['id_estados'] }}"
                        @if ($estado['id_estados'] == $empleadoTarea['emp_tar_estado_tarea']) selected @endif>
                            {{ $estado['nombre_estado'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar Estado.</button>
                <!-- Botón para Volver, este redirige a la ruta de tareas asignadas -->
                <a href="{{ route('tareas-asignadas') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
</x-app-layout>
