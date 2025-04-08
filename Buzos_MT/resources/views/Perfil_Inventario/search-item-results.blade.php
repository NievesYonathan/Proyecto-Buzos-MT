<x-app-layout>
    <div class="container-fluid">
        <form class="form-neon" action="{{ route('resultados-producto') }}" method="post">
            @csrf
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué item estás buscando?</label>
                        <input type="text" class="form-control" name="busqueda" id="inputSearch" maxlength="30" value="{{ $busqueda }}" required>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info">
                            <i class="fas fa-search"></i> &nbsp; BUSCAR
                        </button>
                    </p>
                    <p class="text-center" style="margin-top: 40px;">
                        <a href="{{ route('buscar-producto') }}" class="btn btn-raised btn-danger">
                            <i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA
                        </a>
                    </p>
                </div>
            </div>
        </form>
        <br>

        @if ($materiaPrima->isNotEmpty())
            <p class="text-center table-light" style="font-size: 20px;">
                Resultados de la búsqueda: <strong>"{{ $busqueda }}"</strong>
            </p>

            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>STOCK</th>
                            <th>ACTUALIZAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiaPrima as $item)
                            <tr class="text-center table-light details">
                                <td>{{ $item->id_materia_prima }}</td>
                                <td>{{ $item->mat_pri_nombre }}</td>
                                <td>{{ $item->mat_pri_cantidad }}</td>
                                <td>
                                    <form action="{{ route('editar-producto', $item->id_materia_prima) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="matId" value="{{ $item->id_materia_prima }}">
                                        <input type="hidden" name="matNombre" value="{{ $item->mat_pri_nombre }}">
                                        <input type="hidden" name="matDescripcion" value="{{ $item->mat_pri_descripcion }}">
                                        <input type="hidden" name="matCantidad" value="{{ $item->mat_pri_cantidad }}">
                                        <input type="hidden" name="matEstado" value="{{ $item->mat_pri_estado }}">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center table-light" style="font-size: 20px;">
                <strong>"No hay resultados para tu búsqueda"</strong>
            </p>
        @endif
    </div>
</x-app-layout>
