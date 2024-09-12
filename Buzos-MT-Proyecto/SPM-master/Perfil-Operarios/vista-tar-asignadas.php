<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <?php 
    include '../Config/variable_global.php';
    include '../Componentes/Head/head.php'; ?>

<body>

    <!-- Nav lateral -->
    <?php include '../Componentes/Sidebar/sidebar.php'; ?>

    <!-- Page content -->
    <section class="full-box page-content">
        <!-- Navbar -->
        <?php include '../Componentes/Navbar/navbar.php'; ?>

        <!-- Page header -->
        <div class="full-box page-header">
            <h3 class="text-left">
                <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; TAREAS ASIGNADAS
            </h3>
        </div>

        

        <!-- Content -->
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark table-sm">
            <thead>
                <tr class="text-center roboto-medium">
                    <th>#</th>
                    <th>Nombre de la Tarea</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Plazo de Entrega</th>
                    <th>Actualizar</th>
					<th>Visualizar la produccion</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>1</td>
                    <td>Revisión de Documentos</td>
                    <td>Revisar la documentación entregada.</td>
                    <td>En Progreso</td>
                    <td>2024-09-15</td>
                    <td>
                        <button type="button" class="btn btn-success" 
                                data-toggle="modal" 
                                data-target="#modalTarea" 
                                data-tarea="Revisión de Documentos"
                                data-descripcion="Revisar la documentación entregada." 
                                data-estado="En Progreso"
                                data-plazo="2024-09-15">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>
					<td>
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detalleProduccion"><i class="fa-solid fa-industry"></i></button>
					</td>
					<!-- Modal-Detalles-Producción -->
					<div class="modal fade" id="detalleProduccion" tabindex="-1" role="dialog" data-bs-backdrop="static">
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
												<p id="recursosAsignados">Máquina de coser industrial, Mesa de corte, Personal de costura</p>
											</div>
											<div class="col-12">
												<h6><strong>12. Comentarios o Notas:</strong></h6>
												<p id="comentariosNotas">Ajustar las costuras laterales para mayor durabilidad.</p>
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
                </tr>
                <tr class="text-center">
                    <td>2</td>
                    <td>Entrega de Reporte</td>
                    <td>Preparar y entregar el reporte de actividades.</td>
                    <td>Completada</td>
                    <td>2024-09-10</td>
                    <td>
                        <button type="button" class="btn btn-success" 
                                data-toggle="modal" 
                                data-target="#modalTarea" 
                                data-tarea="Entrega de Reporte"
                                data-descripcion="Preparar y entregar el reporte de actividades." 
                                data-estado="Completada"
                                data-plazo="2024-09-10">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>
					<td>
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detalleProduccion"><i class="fa-solid fa-industry"></i></button>
					</td>
                </tr>
                <tr class="text-center">
                    <td>3</td>
                    <td>Auditoría de Calidad</td>
                    <td>Verificar la calidad del producto.</td>
                    <td>Pendiente</td>
                    <td>2024-09-20</td>
                    <td>
                        <button type="button" class="btn btn-success" 
                                data-toggle="modal" 
                                data-target="#modalTarea" 
                                data-tarea="Auditoría de Calidad"
                                data-descripcion="Verificar la calidad del producto." 
                                data-estado="Pendiente"
                                data-plazo="2024-09-20">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>
					<td>
							<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detalleProduccion"><i class="fa-solid fa-industry"></i></button>
					</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal único -->
<div class="modal fade" id="modalTarea" tabindex="-1" aria-labelledby="modalTareaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTareaLabel">Actualizar Tarea</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTarea">
                    <div class="form-group">
                        <label for="estadoTarea">Estado</label>
                        <select class="form-control" id="estadoTarea">
                            <option>En Progreso</option>
                            <option>Completada</option>
                            <option>Pendiente</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </section>
		<!--===Include JavaScript files======-->
		<?php include '../Componentes/Script/script.php' ?>
</body>
</html>