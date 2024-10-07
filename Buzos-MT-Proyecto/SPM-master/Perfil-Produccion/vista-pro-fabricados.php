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
			<!-- Navbar -->
			<?php include '../Componentes/Navbar/navbar.php' ?>

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; Gestion Productos Fabricados
				</h3>
			</div>

			<!-- Content -->
			<div class="full-box tile-container">
				<?php
				include_once "../Controlador/ControladorEtapas.php";
				$objEta = new ControladorEtapa();
				$etapas = [];
				$resE = $objEta->consultarEtapas();
				while ($filaE = $resE->fetch_assoc()) {
					$etapas[] = $filaE;
				}
				
				include_once "../Controlador/ControladorMateriasP.php";
				$objEta = new ControladorMateriaPrima();
				$materiaPri = [];
				$resM = $objEta->consultarMateriaPrima();
				while ($filaM = $resM->fetch_assoc()) {
					$materiaPri[] = $filaM;
				}

				// Se debe corregir el controlador de Tarea
				include_once '../Modelo/Conexion.php';
				$conexion = new Conexion();
				$conectarse = $conexion->conectarse();		
		
				$sql = "SELECT * FROM tarea";
				$resT = $conectarse->query($sql);
				$conectarse->close();

				$tarea = [];
				while ($filaT = $resT->fetch_assoc()) {
					$tarea[] = $filaT;
				}
				//------	obtenerUsuarioOperario()

				include_once "../Controlador/ControladorUsuario.php";
				$objUsu = new ControladorUsuario();
				$operario = [];
				$resU = $objUsu->obtenerUsuarioOperario();
				while ($filaU = $resU->fetch_assoc()) {
					$operario[] = $filaU;
				}

				include_once "../Controlador/ControladorProFabricados.php";
				$objPro = new ConstroladorProFabricados();
				$res = $objPro->consultarPro();

				while ($fila = $res->fetch_assoc()) {
				?>
					<div class="product-list mb-4">
						<div class="product-item">
							<img src="../assets/img/producto.jpg" alt="Producto" class="product-image">
							<div class="product-info">
								<h3 class="product-name"><?= $fila['pro_nombre'] ?></h3>
								<p class="product-quantity">Cantidad de Producción: <?= $fila['reg_pf_cantidad'] ?></p>
								<p class="product-dates">Fecha de Inicio: <?= date('Y-m-d', strtotime($fila['pro_fecha_inicio'])) ?> - Fecha de Fin: <?= date('Y-m-d', strtotime($fila['pro_fecha_fin'])) ?></p>
								<p class="product-status">Etapa: <?= $fila['eta_nombre'] ?></p>
								<p class="product-material">Material: <?= $fila['reg_pf_material'] ?></p>
								<div class="product-actions">
									<button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateModal<?= $fila['id_produccion'] ?>">Ver Detalles</button>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal-Ediciòn -->
					<div class="modal fade" id="updateModal<?= $fila['id_produccion'] ?>" tabindex="-1" role="dialog" data-bs-backdrop="static">
						<div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered" role="document">
							<div class="modal-content">

								<div class="modal-header">
									<h5 class="modal-title">Gestionar Producción | <?= $fila['id_produccion'] ?></h5>
									<button class="btn-close" data-bs-dismiss="modal"></button>
								</div>

								<div class="modal-body">
									<form action="../Controlador/ControladorProduccion.php" method="POST" class="form-neon" autocomplete="off">
										<fieldset>
											<legend><i class="fas fa-industry"></i> &nbsp; Información de la producción</legend>
											<div class="container-fluid">
												<div class="row">
													<div class="col-12 col-md-4">
														<div class="form-group">
															<label for="produccion_nombre" class="bmd-label-floating">Nombre de la Producción</label>
															<input type="text" class="form-control border border-dark" name="produccion_nombre" id="produccion_nombre" maxlength="50" value="<?= $fila['pro_nombre'] ?>" required>
														</div>
													</div>

													<div class="col-12 col-md-4">
														<div class="form-group">
															<label for="produccion_fecha_inicio" class="bmd-label-floating">Fecha de Inicio</label>
															<input type="date" class="form-control border border-dark" name="produccion_fecha_inicio" id="productionDate" value="<?= $fila['pro_fecha_inicio'] ?>" required>
														</div>
													</div>

													<div class="col-12 col-md-4">
														<div class="form-group">
															<label for="produccion_fecha_fin" class="bmd-label-floating">Fecha de Finalización</label>
															<input type="date" class="form-control border border-dark" name="produccion_fecha_fin" id="produccion_fecha_fin" value="<?= $fila['pro_fecha_fin'] ?>" required>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-12 col-md-6">
														<div class="form-group">
															<label for="produccion_cantidad" class="bmd-label-floating">Cantidad de Producción</label>
															<input type="number" class="form-control border border-dark" name="produccion_cantidad" id="produccion_cantidad" maxlength="50" value="<?= $fila['pro_cantidad'] ?>" required>
														</div>
													</div>

													<div class="col-12 col-md-6">
														<div class="form-group">
															<label for="produccion_etapa" class="bmd-label-floating">Etapa</label>
															<select class="form-control border border-dark" id="produccion_etapa" name="produccion_etapa" required>
																<?php
																foreach ($etapas as $estapa) { ?>
																	<option value="<?= $estapa['id_etapas'] ?>" <?= ($fila['pro_etapa'] == $fila['t_doc'] ? 'selected' : '') ?>><?= $estapa['eta_nombre'] ?></option>
																<?php
																}
																?>
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
															<select class="form-control border border-dark" id="produccion_mtPrima1" name="produccion_mtPrima[]" required>
																<?php
																foreach($materiaPri AS $materia) { ?>
																	<option value="<?= $materia['id_materia_prima'] ?>"><?= $materia['mat_pri_nombre'] ?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>

													<div class="col-12 col-md-6">
														<div class="form-group">
															<label for="mtPrima_cantidad" class="bmd-label-floating">Cantidad</label>
															<input type="number" class="form-control border border-dark" name="mtPrima_cantidad" id="mtPrima_cantidad1" maxlength="50" required>
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
															<select class="form-control border border-dark" id="produccion_tarea1" name="produccion_tarea[]" required>
																<option value="">Tarea</option>
																<?php
																foreach ($tarea AS $filaT) { ?>
																	<option value="<?= $filaT['id_tarea'] ?>"><?= $filaT['tar_nombre'] ?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>

													<div class="col-12 col-md-4" id="resp-container">
														<div class="form-group">
															<select class="form-control border border-dark" id="produccion_responsable1" name="produccion_responsable" required>
																<option value="">Responsable</option>
																<?php
																foreach($operario AS $fila) { ?>
																	<option value="<?= $fila['num_doc'] ?>"><?= $fila['usu_nombres'] . ' ' . $fila['usu_apellidos'] ?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>
													<div class="col-12 col-md-4" id="fEntrega-container">
														<div class="form-group">
															<input type="text" class="form-control border border-dark" name="produccion_fecha_entrega" id="produccion_fecha_entrega1" onfocus="(this.type='date')" onblur="if(!this.value) this.type='text';" placeholder="Fecha de Entrega" required>

															<!-- <input type="date" class="form-control border border-dark" name="produccion_fecha_entrega" id="produccion_fecha_entrega1" onfocus="this.type='date'" onblur="this.type='text'" placeholder="Fecha de Entrega" required> -->
														</div>
													</div>
													<div class="col-12">
														<button type="button" id="addTareaBtn" class="btn btn-info mt-3">Agregar otra tarea</button>
													</div>
												</div>
											</div>
										</fieldset>

										<p class="text-center" style="margin-top: 40px;">
											<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
											&nbsp; &nbsp;
											<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
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
				<?php
				}
				?>
			</div>


		</section>
	</main>


	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>

</body>

</html>