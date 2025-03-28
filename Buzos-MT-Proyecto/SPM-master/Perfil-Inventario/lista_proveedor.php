<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php
include '../Config/variable_global.php';
include '../Componentes/Head/head.php';
?>

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
				<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PROVEEDORES
			</h3>
		</div>

		<div class="container-fluid">
			<ul class="full-box list-unstyled page-nav-tabs">
				<li>
					<a href="CPP.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PROVEEDOR</a>
				</li>
				<li>
					<a class="active" href="LPP.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA
						DE PROVEEDORES</a>
				</li>
				<li>
					<a href="PPS.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PROVEEDOR</a>
				</li>
			</ul>
		</div>

		<!-- Content -->
		<div class="container-fluid">
			<div class="table-responsive">
				<table class="table table-dark table-sm">
					<thead>
						<tr class="text-center roboto-medium">
							<th>Tipo de documento</th>
							<th>Numero de documento</th>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Dirección</th>
							<th>Teléfono</th>
							<th>Email</th>
							<th>Estado</th>
							<th>Actualizar</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include_once '../Modelo/Conexion.php';
						$conexion = new Conexion();
						$conectarse = $conexion->conectarse();

						$sql = "SELECT * FROM tipo_doc";
						$resT = $conectarse->query($sql);
						$conectarse->close();

						$tipoDoc = [];

						while ($filaT = $resT->fetch_assoc()) {
							$tipoDoc[] =  $filaT;
						}
						//----
						$conexion = new Conexion();
						$conectarse = $conexion->conectarse();

						$sql = "SELECT * FROM estados";
						$resE = $conectarse->query($sql);
						$conectarse->close();

						$estados = [];

						while ($filaE = $resE->fetch_assoc()) {
							$estados[] =  $filaE;
						}
						//----

						include_once "../Controlador/ControladorUsuario.php";

						$controladorUsuario = new ControladorUsuario();
						$res = $controladorUsuario->mostrarProveedor();


						while ($fila = $res->fetch_assoc()) {
						?>
							<tr class="text-center">
								<td>
									<?php
									// Inicializa la variable para almacenar la descripción
									$tipoDescripcion = '';

									// Busca la descripción correcta para el tipo de documento
									foreach ($tipoDoc as $tipo) {
										if ($tipo['id_tipo_documento'] == $fila['t_doc']) {
											$tipoDescripcion = $tipo['tip_doc_descripcion'];
											break; // Salir del bucle una vez que se encuentre la coincidencia
										}
									}
									// Muestra la descripción del tipo de documento
									echo $tipoDescripcion;
									?>
								</td>
								<td><?= $fila['num_doc'] ?></td>
								<td><?= $fila['usu_nombres'] ?></td>
								<td><?= $fila['usu_apellidos'] ?></td>
								<td><?= $fila['usu_direccion'] ?></td>
								<td><?= $fila['usu_telefono'] ?></td>
								<td><?= $fila['usu_email'] ?></td>
								<td><?= $fila['estado_usuario'] ?></td>
								<td>
									<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal<?= $fila['num_doc'] ?>">
										<i class="fa-solid fa-user-pen"></i>
									</button>
								</td>
								<td>
									<form action="../Controlador/ControladorUsuario.php" method="post">
										<input type="hidden" name="accion" value="eliminar">
										<input type="hidden" name="num_doc" value="<?= $fila['num_doc'] ?>">
										<button class="btn btn-danger" type="submit">
											<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>
							<!-- Modal para editar usuarios -->
							<div class="modal fade" id="updateModal<?= $fila['num_doc'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="addModalLabel">Modificar Usuario - <?php echo $fila['num_doc']; ?></h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="../Controlador/ControladorUsuario.php" method="post">
												<fieldset>
													<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="tipo_documento" class="bmd-label-floating">Tipo documento</label>
																	<select class="form-select" aria-label="Default select example" id="tipoDocumento" name="tipoDocumento" required>
																		<?php
																		foreach ($tipoDoc as $filaT) { ?>
																			<option value="<?= $filaT['id_tipo_documento'] ?>" <?= ($filaT['id_tipo_documento'] == $fila['t_doc'] ? 'selected' : '') ?> readonly><?= $filaT['tip_doc_descripcion'] ?></option>
																		<?php
																		}
																		?>
																	</select>
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_dni" class="bmd-label-floating">Numero de documento</label>
																	<input type="number" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni" id="usuario_dni" value="<?php echo $fila['num_doc'] ?>" readonly>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
																	<input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="<?php echo $fila['usu_nombres'] ?>" maxlength="60">
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
																	<input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido" value="<?php echo $fila['usu_apellidos'] ?>" maxlength="40">
																</div>
															</div>
														</div>
													</div>
												</fieldset>
												<br><br>
												<fieldset>
													<legend><i class="fas fa-user-lock"></i> &nbsp; Información de Contacto</legend>
													<div class="container-fluid">
														<div class="row">
															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
																	<input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,190}" class="form-control" name="usuario_direccion" id="usuario_direccion" maxlength="190" value="<?php echo $fila['usu_direccion'] ?>">
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
																	<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_telefono" id="usuario_telefono" maxlength="20" value="<?php echo $fila['usu_telefono'] ?>">
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_email" class="bmd-label-floating">Email</label>
																	<input type="email" class="form-control" name="usuario_email" id="usuario_email" maxlength="70" value="<?php echo $fila['usu_email'] ?>">
																</div>
															</div>

															<div class="col-12 col-md-6">
																<div class="form-group">
																	<label for="usuario_estado" class="bmd-label-floating">Estado</label>
																	<!-- <input type="number" class="form-control" name="usuario_estado" id="usuario_estado" maxlength="70" value="<?php echo $fila['usu_estado'] ?>"> -->
																	<select class="form-select" aria-label="Default select example" id="usuario_estado" name="usuario_estado" required>
																		<?php
																		foreach ($estados as $filaEs) { ?>
																			<option value="<?= $filaEs['id_estados'] ?>" <?= ($filaEs['id_estados'] == $fila['usu_estado'] ? 'selected' : '') ?>><?= $filaEs['nombre_estado'] ?></option>
																		<?php
																		}
																		?>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</fieldset>
										</div>
										<div class="modal-footer">
											<button class="btn btn-success" type="submit" name="Accion" value="Actualizar">Actualizar</button>
											</form>

										</div>
									</div>
								</div>
							</div>
						<?php
						}
						?>
					</tbody>
				</table>

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
	</main>

	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php'; ?>
</body>

</html>