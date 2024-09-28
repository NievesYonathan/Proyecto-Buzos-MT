<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header('Location: ../Login-Registro/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<?php
include '../Config/variable_global.php';

include '../Componentes/Head/head.php' ?>

<body>

	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<?php include '../Componentes/Sidebar/sidebar.php' ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<nav class="full-box navbar-info">
				<a href="#" class="float-left show-nav-lateral">
					<i class="fas fa-exchange-alt"></i>
				</a>
				<a href="user-update.html">
					<i class="fas fa-user-cog"></i>
				</a>
				<a href="#" class="btn-exit-system">
					<i class="fas fa-power-off"></i>
				</a>
			</nav>

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; PRODUCCIÓN
				</h3>
			</div>

			<!-- Content -->
			<div class="container">
				<div class="row">
					<div class="mb-5 col-sm-6 col-md-6 col-lg-5">
						<div class="pro-btns">
							<div class="pro-btn">
								<button type="button" name="agregar" value="agregar" class="btn" data-bs-toggle="modal" data-bs-target="#agregar"><i class="fa-solid fa-square-plus fa-2xl" style="color: #2baf54;"></i></button>
								<p>Gestionar Producción</p>
							</div>

							<!-- Gestionar Producción - Modal -->
							<div class="modal fade" id="agregar" tabindex="-1" role="dialog" data-bs-backdrop="static">
								<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
									<div class="modal-content">

										<div class="modal-header">
											<h5 class="modal-title">Gestionar Producción:</h5>
											<button class="btn-close" data-bs-dismiss="modal"></button>
										</div>

										<div class="modal-body">
											<form action="" class="form-neon" autocomplete="off">
												<fieldset>
													<legend><i class="fas fa-industry"></i> &nbsp; Información de la producción</legend>
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-md-4">
																<div class="form-group">
																	<label for="produccion_nombre" class="bmd-label-floating">Nombre de la Producción</label>
																	<input type="text" class="form-control border border-dark" name="produccion_nombre" id="produccion_nombre" maxlength="50" required>
																</div>
															</div>

															<div class="col-12 col-md-4">
																<div class="form-group">
																	<label for="produccion_fecha_inicio" class="bmd-label-floating">Fecha de Inicio</label>
																	<input type="date" class="form-control border border-dark" name="produccion_fecha_inicio" id="produccion_fecha_inicio" required>
																</div>
															</div>

															<div class="col-12 col-md-4">
																<div class="form-group">
																	<label for="produccion_fecha_fin" class="bmd-label-floating">Fecha de Finalización</label>
																	<input type="date" class="form-control border border-dark" name="produccion_fecha_fin" id="produccion_fecha_fin" required>
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
																	<label for="produccion_tarea" class="bmd-label-floating">Tarea Asignada</label>
																	<input type="text" class="form-control border border-dark" name="produccion_tarea" id="produccion_tarea" maxlength="50" required>
																</div>
															</div>

															<div class="col-12 col-md-4">
																<div class="form-group">
																	<label for="produccion_estado" class="bmd-label-floating">Estado de la Producción</label>
																	<select class="form-control border border-dark" name="produccion_estado" id="produccion_estado">
																		<option value="" selected="" disabled="">Seleccione un estado</option>
																		<option value="en_progreso">En Progreso</option>
																		<option value="completado">Completado</option>
																		<option value="pendiente">Pendiente</option>
																	</select>
																</div>
															</div>

															<div class="col-12 col-md-4">
																<div class="form-group">
																	<label for="produccion_responsable" class="bmd-label-floating">Responsable</label>
																	<input type="text" class="form-control border border-dark" name="produccion_responsable" id="produccion_responsable" maxlength="50" required>
																</div>
															</div>
														</div>
													</div>
												</fieldset>

												<p class="text-center" style="margin-top: 40px;">
													<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
													&nbsp; &nbsp;
													<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
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


							<div class="pro-btn">
								<button type="button" name="tarea" value="tarea" class="btn" data-bs-toggle="modal" data-bs-target="#tarea"><i class="fa-solid fa-file-circle-plus fa-2xl" style="color: #2baf54;"></i></button>
								<p>Gestionar Tareas</p>
							</div>

							<!-- Gestionar Tarea - Modal -->
							<div class="modal fade" id="tarea" tabindex="-1" role="dialog" data-bs-backdrop="static">
								<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
									<div class="modal-content">

										<div class="modal-header">
											<h5 class="modal-title">Gestionar Tareas:</h5>
											<button class="btn-close" data-bs-dismiss="modal"></button>
										</div>

										<div class="modal-body">
											<form action="" class="form-neon" autocomplete="off">
												<fieldset>
													<legend><i class="far fa-address-card"></i> &nbsp; Información de la tarea</legend>
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="estado_tarea" class="bmd-label-floating">Tarea</label>
																	<select class="form-control" name="estado_tarea" id="estado_tarea">
																		<option value="" selected="" disabled="">Seleccione una opción</option>
																		<option value="Pendiente">Pendiente</option>
																		<option value="En Proceso">En Proceso</option>
																		<option value="Completada">Completada</option>
																	</select>
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="empleado_id" class="bmd-label-floating">ID del Empleado</label>
																	<input type="text" pattern="[0-9]{1,20}" class="form-control" name="empleado_id" id="empleado_id" maxlength="20">
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="fecha_asignacion" class="bmd-label-floating">Fecha de Asignación</label>
																	<input type="date" class="form-control" name="fecha_asignacion" id="fecha_asignacion">
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="fecha_entrega" class="bmd-label-floating">Fecha de Entrega</label>
																	<input type="date" class="form-control" name="fecha_entrega" id="fecha_entrega">
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<br><br><br>
												<fieldset>
													<legend><i class="fas fa-user-lock"></i> &nbsp; Estado y Descripción</legend>
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="estado_tarea" class="bmd-label-floating">Estado de la Tarea</label>
																	<select class="form-control" name="estado_tarea" id="estado_tarea">
																		<option value="" selected="" disabled="">Seleccione una opción</option>
																		<option value="Pendiente">Pendiente</option>
																		<option value="En Proceso">En Proceso</option>
																		<option value="Completada">Completada</option>
																	</select>
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="descripcion_tarea" class="bmd-label-floating">Descripción de la Tarea</label>
																	<textarea class="form-control" name="descripcion_tarea" id="descripcion_tarea" maxlength="200"></textarea>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<p class="text-center" style="margin-top: 40px;">
													<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
													&nbsp; &nbsp;
													<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
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
								<button type="button" name="detalle" value="detalle" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detalleProduccion">Ver Detalles</button>
								<!-- <a href="#" class="pro-ver">Ver Detalles</a> -->
							</div>
							<div class="pro-res-detalle">
								<p>Producción: <span>Buzos Amarillos de Algodón</span></p>
								<p>Etapa: <span>2 - Armado de los patrones.</span></p>
								<button type="button" name="detalle" value="detalle" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detalleProduccion">Ver Detalles</button>
								<!-- <a href="#" class="pro-ver">Ver Detalles</a> -->
							</div>
						</div>

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
						<!-- Fin-Modal -->
					</div>

					<div class="col-sm-6 col-md-6 col-lg-7">
						<div id="calendar"></div>
						<!-- Modal de Calendario - Producción -->
						<div class="modal fade" id="productionModal" tabindex="-1" role="dialog" aria-labelledby="productionModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="productionModalLabel">Registrar Producción</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="productionForm">
											<div class="form-group">
												<label for="productionDate">Fecha de Producción:</label>
												<input type="text" class="form-control" id="productionDate" name="productionDate" readonly>
											</div>
											<button type="submit" class="btn btn-primary">Registrar</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>

	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
	<script src="../js/calendear.js"></script>
</body>

</html>