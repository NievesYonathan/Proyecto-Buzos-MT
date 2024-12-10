<x-app-layout>
    <!--CONTENT-->
    <div class="container-fluid">
        <div class="table-overflow-x">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>STOCK</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materiaPrima as $item)
                    <tr class="text-center table-light details" style="cursor:pointer"
                        onclick="document.getElementById('Detalles<?= $item->id_materia_prima ?>').submit();">
                        <td><?= $item->id_materia_prima ?></td>
                        <td><?= $item->mat_pri_nombre ?></td>
                        <td><?= $item->mat_pri_cantidad ?></td>
                        <td>
                            <form action="{{ route('editar-producto', $item->id_materia_prima)}}" method="post">
                                @csrf
                                <input type="hidden" name="matId" value="<?= $item->id_materia_prima ?>">
                                <input type="hidden" name="matNombre" value="<?= $item->mat_pri_nombre ?>">
                                <input type="hidden" name="matDescripcion"
                                    value="<?= $item->mat_pri_descripcion ?>">
                                <input type="hidden" name="matCantidad" value="<?= $item->mat_pri_cantidad ?>">
                                <input type="hidden" name="matEstado" value="<?= $item->mat_pri_estado ?>">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('materia-prima-delete', $item->id_materia_prima )}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="matId" value="<?= $item->id_materia_prima ?>">
                            <button type="submit" class="btn btn-danger">
                                    <i class="far fa-trash-alt"></i>
                            </button>
                            </form>
                            <form action="{{ route('Detalles-producto', $item->id_materia_prima)}}" id="Detalles<?= $item->id_materia_prima ?>"
                                method="post">
                                @csrf
                                <input type="hidden" name="matId" value="<?= $item->id_materia_prima ?>">
                                <input type="hidden" name="matNombre" value="<?= $item->mat_pri_nombre ?>">
                                <input type="hidden" name="matDescripcion"
                                    value="<?= $item->mat_pri_descripcion ?>">
                                <input type="hidden" name="matUnidad" value="<?= $item->mat_pri_unidad_medida ?>">
                                <input type="hidden" name="matCantidad" value="<?= $item->mat_pri_cantidad ?>">
                                <input type="hidden" name="matEstado" value="<?= $item->mat_pri_estado ?>">
                            </form>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="<?= $item->id_materia_prima ?>" tabindex="-1"
                        aria-labelledby="movimientosLabel<?= $item->id_materia_prima ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="movimientosLabel<?= $item->id_materia_prima ?>">
                                        Movimientos de: <?= $item->mat_pri_nombre . ' - ' . $item->id_materia_prima ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div> <!-- Aquí puedes agregar más movimientos dinámicamente si los tienes -->
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </section>
    </main>
</x-app-layout>