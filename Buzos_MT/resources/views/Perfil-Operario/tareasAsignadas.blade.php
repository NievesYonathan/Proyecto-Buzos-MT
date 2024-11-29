<x-app-layout>
    <div class="container mt-5">
        <div class="table-responsive">
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
                            @foreach ($tareas->empleados as $empleado)
                                <tr class="text-center">
                                    <td>{{ $tareas->id_tarea }}</td>
                                    <td>{{ $tareas->tar_nombre }}</td>
                                    <td>{{ $tareas->tar_descripcion }}</td>
                                    @php
                                        // Encuentra el estado correspondiente al valor de 'emp_tar_estado_tarea'
                                        $estadoCorrespondiente = $estados->firstWhere('id_estados', $empleado->pivot->emp_tar_estado_tarea);
                                    @endphp
                                    <td>{{ $estadoCorrespondiente ? $estadoCorrespondiente->nombre_estado : 'Estado no encontrado'  }}</td>
                                    <td>{{ $empleado->pivot->emp_tar_fecha_asignacion }}</td>
                                    <td>{{ $empleado->pivot->emp_tar_fecha_entrega }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal"
                                            data-target="#actualizarEstado{{ $empleado->pivot->id_empleado_tarea }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                </tbody>
            </table>
            
                                <!-- Modal para actualizar estado -->
                                <div class="modal fade"
                                    id="actualizarEstado{{ $empleado->pivot->id_empleado_tarea }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modalLabelEstado" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabelEstado{{ $tareas->id_tarea }}">
                                                    Actualizar Estado de Tarea</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="../Controlador/ControladorTarea.php">
                                                <input type="hidden" name="accion" value="actualizarEstado">
                                                <input type="hidden" name="id_tarea" value="{{ $tareas->id_tarea }}">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="estadoTarea">Estado</label>
                                                        <select class="form-control" name="estadoTarea" required>
                                                            @foreach ($estados as $estado)
                                                                <option value="{{ $estado->id_estados }}"
                                                                    @if ($estado->id_estados === $empleado->pivot->emp_tar_estado_tarea) selected @endif>
                                                                    {{ $estado->nombre_estado }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar
                                                        Estado</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif

        </div>
    </div>
</x-app-layout>
