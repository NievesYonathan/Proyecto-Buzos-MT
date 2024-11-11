<x-app-layout>
    <div class="container my-5">
        <div class="product-list mb-4">
            <div class="product-item">
                <img src="../assets/img/producto.jpg" alt="Producto" class="product-image">
                <div class="product-info">
                    <h3 class="product-name"></h3>
                    <p class="product-quantity">Cantidad de Producción: </p>
                    <p class="product-dates">Fecha de Inicio: 
                        - Fecha de Fin: </p>
                    <p class="product-status">Etapa: </p>
                    <p class="product-material">Material: </p>
                    <div class="product-actions">
                        <button class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#updateModal">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal-Ediciòn -->
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Gestionar Producción | </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form action="../Controlador/ControladorProduccion.php" method="POST" class="form-neon"
                            autocomplete="off">
                            <input type="hidden" name="id_produccion" value="">
                            <fieldset>
                                <legend><i class="fas fa-industry"></i> &nbsp; Información de la producción</legend>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="produccion_nombre" class="bmd-label-floating">Nombre de la Producción</label>
                                                <input type="text" class="form-control border border-dark" name="produccion_nombre" id="produccion_nombre" maxlength="50" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="produccion_fecha_inicio" class="bmd-label-floating">Fecha de Inicio</label>
                                                <input type="date" class="form-control border border-dark" name="produccion_fecha_inicio" id="productionDate" value="" disabled>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="produccion_fecha_fin" class="bmd-label-floating">Fecha de Finalización</label>
                                                <input type="date" class="form-control border border-dark" name="produccion_fecha_fin" id="produccion_fecha_fin" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="produccion_cantidad" class="bmd-label-floating">Cantidad Produccida</label>
                                                <input type="number" class="form-control border border-dark" name="produccion_cantidad" id="produccion_cantidad" maxlength="50" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="produccion_etapa" class="bmd-label-floating">Etapa</label>
                                                <select class="form-control border border-dark" id="produccion_etapa" name="produccion_etapa" required>
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <br><br>

                            <fieldset>
                                <legend><i class="fas fa-pallet fa-fw"></i> &nbsp; Detalles de Materia Prima</legend>
                                <div class="container-fluid">
                                    <div class="row mt-3" id="mtPrima-container">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="produccion_mtPrima" class="bmd-label-floating">Materia Prima</label>
                                                <input type="hidden" name="idRegistroMP[]" value="">
                                                <select class="form-control border border-dark" id="produccion_mtPrima1" name="produccion_mtPrima[]" required>
                                                    <option value="">Seleccionar</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="mtPrima_cantidad" class="bmd-label-floating">Cantidad</label>
                                                <input type="number" class="form-control border border-dark" name="mtPrima_cantidad[]" id="mtPrima_cantidad1" maxlength="50" value="" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="button" id="addMtPrimaBtn" class="btn btn-info mt-3">Agregar otra Materia Prima</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <br><br>

                            <fieldset>
                                <legend><i class="fas fa-tasks"></i> &nbsp; Detalles de la Tarea</legend>
                                <div class="container-fluid">
                                    <div class="row" id="tarea-container">
                                        <div class="col-12 col-md-4 mb-2">
                                            <div class="form-group">
                                                <input type="hidden" name="idRegistroET[]" value="">
                                                <select class="form-control border border-dark" id="produccion_tarea1" name="produccion_tarea[]" required>
                                                    <option value="">Tarea</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-2" id="resp-container">
                                            <div class="form-group">
                                                <select class="form-control border border-dark" id="produccion_responsable1" name="produccion_responsable[]" required>
                                                    <option value="">Responsable</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4 mb-2" id="fEntrega-container">
                                            <div class="form-group">
                                                <input type="date" class="form-control border border-dark" name="produccion_fecha_entrega[]" id="produccion_fecha_entrega1" value="" required>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="col-12">
                                            <button type="button" id="addTareaBtn" class="btn btn-info mt-3">Agregar otra tarea</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <p class="text-center" style="margin-top: 40px;">
                                <button type="reset" class="btn btn-raised btn-secondary btn-sm">
                                    <i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
                                </button>
                                &nbsp; &nbsp;
                                <button type="submit" name="btn-produccion" value="editar" class="btn btn-raised btn-success btn-sm">
                                    <i class="far fa-save"></i> &nbsp; GUARDAR
                                </button>
                            </p>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Model Producción -->
    </div>
</x-app-layout>
