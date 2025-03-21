<x-app-layout>
    <div class="my-5">
        <div class="row">
            <div class="mb-5 col-sm-6 col-md-6 col-lg-5">
                <div class="pro-btns">
                    <div class="pro-btn">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#agregar">
                            <i class="fa-solid fa-square-plus fa-2xl" style="color: #2baf54;"></i>
                        </button>
                        <p>Gestionar Producción</p>
                    </div>
                    <!-- Modal para gestionar producción -->
                    <div class="modal fade" id="agregar" tabindex="-1" role="dialog" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Gestionar Producción:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="#" method="POST" class="form-neon" autocomplete="off">
                                        @csrf
                                        <fieldset>
                                            <legend><i class="fas fa-industry"></i> &nbsp; Información de la producción
                                            </legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_nombre"
                                                                class="bmd-label-floating">Nombre de
                                                                la Producción</label>
                                                            <input type="text"
                                                                class="form-control border border-dark"
                                                                name="produccion_nombre" id="produccion_nombre"
                                                                maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_fecha_inicio"
                                                                class="bmd-label-floating">Fecha de Inicio</label>
                                                            <input type="date"
                                                                class="form-control border border-dark"
                                                                name="produccion_fecha_inicio"
                                                                id="produccion_fecha_inicio" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_fecha_fin"
                                                                class="bmd-label-floating">Fecha
                                                                de Finalización</label>
                                                            <input type="date"
                                                                class="form-control border border-dark"
                                                                name="produccion_fecha_fin" id="produccion_fecha_fin"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <br><br><br>

                                        <fieldset>
                                            <legend><i class="fas fa-tasks"></i> &nbsp; Detalles de la Tarea</legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_tarea"
                                                                class="bmd-label-floating">Tarea
                                                                Asignada</label>
                                                            <input type="text"
                                                                class="form-control border border-dark"
                                                                name="produccion_tarea" id="produccion_tarea"
                                                                maxlength="50" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_estado"
                                                                class="bmd-label-floating">Estado de
                                                                la Producción</label>
                                                            <select class="form-control border border-dark"
                                                                name="produccion_estado" id="produccion_estado">
                                                                <option value="" selected disabled>Seleccione un
                                                                    estado
                                                                </option>
                                                                <option value="en_progreso">En Progreso</option>
                                                                <option value="completado">Completado</option>
                                                                <option value="pendiente">Pendiente</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="produccion_responsable"
                                                                class="bmd-label-floating">Responsable</label>
                                                            <input type="text"
                                                                class="form-control border border-dark"
                                                                name="produccion_responsable"
                                                                id="produccion_responsable" maxlength="50" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="text-center" style="margin-top: 40px;">
                                            <button type="reset" class="btn btn-secondary btn-sm"><i
                                                    class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                                            <button type="submit" class="btn btn-info btn-sm"><i
                                                    class="far fa-save"></i>
                                                &nbsp; GUARDAR</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Modal Producción -->

                    <div class="pro-btn">
                        <button type="button" name="tarea" value="tarea" class="btn" data-bs-toggle="modal"
                            data-bs-target="#tarea"><i class="fa-solid fa-file-circle-plus fa-2xl"
                                style="color: #2baf54;"></i></button>
                        <p>Gestionar Tareas</p>
                    </div>

                    <!-- Gestionar Tarea - Modal -->
                    <div class="modal fade" id="tarea" tabindex="-1" role="dialog" data-bs-backdrop="static">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered"
                            role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Gestionar Tareas:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="" class="form-neon" autocomplete="off">
                                        <fieldset>
                                            <legend><i class="far fa-address-card"></i> &nbsp; Información de la tarea
                                            </legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="estado_tarea"
                                                                class="bmd-label-floating">Tarea</label>
                                                            <select class="form-control" name="estado_tarea"
                                                                id="estado_tarea">
                                                                <option value="" selected="" disabled="">
                                                                    Seleccione una opción</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="En Proceso">En Proceso</option>
                                                                <option value="Completada">Completada</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="empleado_id" class="bmd-label-floating">ID del
                                                                Empleado</label>
                                                            <input type="text" pattern="[0-9]{1,20}"
                                                                class="form-control" name="empleado_id"
                                                                id="empleado_id" maxlength="20">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="fecha_asignacion"
                                                                class="bmd-label-floating">Fecha de
                                                                Asignación</label>
                                                            <input type="date" class="form-control"
                                                                name="fecha_asignacion" id="fecha_asignacion">
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="fecha_entrega"
                                                                class="bmd-label-floating">Fecha de
                                                                Entrega</label>
                                                            <input type="date" class="form-control"
                                                                name="fecha_entrega" id="fecha_entrega">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <br><br><br>
                                        <fieldset>
                                            <legend><i class="fas fa-user-lock"></i> &nbsp; Estado y Descripción
                                            </legend>
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="estado_tarea"
                                                                class="bmd-label-floating">Estado de la
                                                                Tarea</label>
                                                            <select class="form-control" name="estado_tarea"
                                                                id="estado_tarea">
                                                                <option value="" selected="" disabled="">
                                                                    Seleccione una opción</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="En Proceso">En Proceso</option>
                                                                <option value="Completada">Completada</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="descripcion_tarea"
                                                                class="bmd-label-floating">Descripción de la
                                                                Tarea</label>
                                                            <textarea class="form-control" name="descripcion_tarea" id="descripcion_tarea" maxlength="200"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <p class="text-center" style="margin-top: 40px;">
                                            <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i
                                                    class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                                            &nbsp; &nbsp;
                                            <button type="submit" class="btn btn-raised btn-info btn-sm"><i
                                                    class="far fa-save"></i> &nbsp; GUARDAR</button>
                                        </p>
                                    </form>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Modal Tarea -->
                </div>

                <div class="pro-resumen">
                    <h4>Resumen de Producción</h4>
                    <div class="pro-res-detalle">
                        <p>Producción: <span>Buzos Amarillos de Algodón</span></p>
                        <p>Etapa: <span>2 - Armado de los patrones.</span></p>
                        <button type="button" name="detalle" value="detalle" class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#detalleProduccion">Ver Detalles</button>
                        <!-- <a href="#" class="pro-ver">Ver Detalles</a> -->
                    </div>
                    <div class="pro-res-detalle">
                        <p>Producción: <span>Buzos Amarillos de Algodón</span></p>
                        <p>Etapa: <span>2 - Armado de los patrones.</span></p>
                        <button type="button" name="detalle" value="detalle" class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#detalleProduccion">Ver Detalles</button>
                        <!-- <a href="#" class="pro-ver">Ver Detalles</a> -->
                    </div>
                </div>

                <!-- Modal-Detalles-Producción -->
                <div class="modal fade" id="detalleProduccion" tabindex="-1" role="dialog"
                    data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Detalles de Producción:</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6><strong>1. Nombre de la Producción:</strong></h6>
                                            <p id="nombreProduccion">Buzos Amarillos de Algodón</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>2. Código de Producción:</strong></h6>
                                            <p id="codigoProduccion">PROD-00123</p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6><strong>3. Fecha de Inicio:</strong></h6>
                                            <p id="fechaInicio">01/08/2024</p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6><strong>4. Fecha Estimada de Finalización:</strong></h6>
                                            <p id="fechaEstimadaFinalizacion">15/08/2024</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>5. Etapas de Producción:</strong></h6>
                                            <ul id="etapasProduccion">
                                                <li>Corte de tela</li>
                                                <li>Costura</li>
                                                <li>Revisión de calidad</li>
                                            </ul>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>6. Estado Actual:</strong></h6>
                                            <p id="estadoActual">2 - Armado de los patrones</p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6><strong>7. Cantidad Total a Producir:</strong></h6>
                                            <p id="cantidadTotal">500 unidades</p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <h6><strong>8. Cantidad Producida:</strong></h6>
                                            <p id="cantidadProducida">250 unidades</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>9. Responsables:</strong></h6>
                                            <ul id="responsables">
                                                <li>Juan Pérez - Corte de tela</li>
                                                <li>María García - Costura</li>
                                                <li>Carlos López - Revisión de calidad</li>
                                            </ul>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>10. Materiales Usados:</strong></h6>
                                            <p id="materialesUsados">Algodón 100%, Hilo de poliéster</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>11. Recursos Asignados:</strong></h6>
                                            <p id="recursosAsignados">Máquina de coser industrial, Mesa de corte,
                                                Personal de costura</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>12. Comentarios o Notas:</strong></h6>
                                            <p id="comentariosNotas">Ajustar las costuras laterales para mayor
                                                durabilidad.</p>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>13. Historial de Cambios:</strong></h6>
                                            <ul id="historialCambios">
                                                <li>05/08/2024: Cambio de proveedor de hilo</li>
                                                <li>07/08/2024: Ajuste en las medidas del patrón</li>
                                            </ul>
                                        </div>
                                        <div class="col-12">
                                            <h6><strong>14. Prioridad:</strong></h6>
                                            <p id="prioridad">Alta</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin-Modal -->
            </div>

            <div class="col-sm-6 col-md-6 col-lg-7">
                <div id="calendar"></div>
                <!-- Modal de Calendario - Producción -->
                <div class="modal fade" id="productionModal" tabindex="-1" role="dialog"
                    data-bs-backdrop="static">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Gestionar Producción:</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('nuevo-producto') }}" method="POST" class="form-neon" autocomplete="off">
                                    @csrf
                                    <fieldset>
                                        <legend><i class="fas fa-industry"></i> &nbsp; Información de la producción
                                        </legend>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="produccion_nombre"
                                                            class="bmd-label-floating">Nombre de la Producción</label>
                                                        <input type="text" class="form-control border border-dark"
                                                            name="produccion_nombre" id="produccion_nombre"
                                                            maxlength="50" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="produccion_fecha_inicio"
                                                            class="bmd-label-floating">Fecha de Inicio</label>
                                                        <input type="date" class="form-control border border-dark"
                                                            name="produccion_fecha_inicio" id="productionDate"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="produccion_fecha_fin"
                                                            class="bmd-label-floating">Fecha de Finalización</label>
                                                        <input type="date" class="form-control border border-dark"
                                                            name="produccion_fecha_fin" id="produccion_fecha_fin"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="produccion_cantidad"
                                                            class="bmd-label-floating">Cantidad de Producción</label>
                                                        <input type="number" class="form-control border border-dark"
                                                            name="produccion_cantidad" id="produccion_cantidad"
                                                            maxlength="50" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="produccion_etapa"
                                                            class="bmd-label-floating">Etapa</label>
                                                        <select class="form-control border border-dark"
                                                            id="produccion_etapa" name="produccion_etapa" required>
                                                            @foreach ($etapas as $etapa)
                                                            <option value="{{ $etapa->id_etapas }}">{{ $etapa->eta_nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <br><br>

                                    <fieldset>
                                        <legend><i class="fas fa-pallet fa-fw"></i> &nbsp; Detalles de Materia Prima
                                        </legend>
                                        <div class="container-fluid">
                                            <div class="row mt-3" id="mtPrima-container">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="produccion_mtPrima"
                                                            class="bmd-label-floating">Materia Prima</label>
                                                        <select class="form-control border border-dark"
                                                            id="produccion_mtPrima1" name="produccion_mtPrima[]"
                                                            required>
                                                            @foreach ($materiasPrimas as $materiaPrima)
                                                            <option value="{{ $materiaPrima->id_materia_prima }}">{{ $materiaPrima->mat_pri_nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="mtPrima_cantidad"
                                                            class="bmd-label-floating">Cantidad</label>
                                                        <input type="number" class="form-control border border-dark"
                                                            name="mtPrima_cantidad[]" id="mtPrima_cantidad1"
                                                            maxlength="50" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" id="addMtPrimaBtn"
                                                        class="btn btn-info mt-3">Agregar otra Materia Prima</button>
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
                                                        <select class="form-control border border-dark"
                                                            id="produccion_tarea1" name="produccion_tarea[]" required>
                                                            <option value="">Tarea</option>
                                                            @foreach ($tareas as $tarea)
                                                            <option value="{{ $tarea->id_tarea }}">{{ $tarea->tar_nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4" id="resp-container">
                                                    <div class="form-group">
                                                        <select class="form-control border border-dark"
                                                            id="produccion_responsable1"
                                                            name="produccion_responsable[]" required>
                                                            <option value="">Responsable</option>
                                                            @foreach ($operarios as $operario)
                                                            <option value="{{ $operario->num_doc }}">{{ $operario->usu_nombres }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4" id="fEntrega-container">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control border border-dark"
                                                            name="produccion_fecha_entrega[]"
                                                            id="produccion_fecha_entrega1"
                                                            onfocus="(this.type='date')"
                                                            onblur="if(!this.value) this.type='text';"
                                                            placeholder="Fecha de Entrega" required>

                                                        <!-- <input type="date" class="form-control border border-dark" name="produccion_fecha_entrega" id="produccion_fecha_entrega1" onfocus="this.type='date'" onblur="this.type='text'" placeholder="Fecha de Entrega" required> -->
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="button" id="addTareaBtn"
                                                        class="btn btn-info mt-3">Agregar otra tarea</button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <p class="text-center" style="margin-top: 40px;">
                                        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i
                                                class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                                        &nbsp; &nbsp;
                                        <button type="submit" name="btn-produccion" value="agregar"
                                            class="btn btn-raised btn-success btn-sm"><i class="far fa-save"></i>
                                            &nbsp; GUARDAR</button>
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
        </div>
    </div>
</x-app-layout>