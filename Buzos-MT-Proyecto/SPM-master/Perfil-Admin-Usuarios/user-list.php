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
	<!-- Inicio Alerta PHP -->
	<?php
	if (isset($_SESSION['alerta'])) {
	?>
		<div id="alerta" class="alert alert-info" role="alert"
			style="position: fixed; top: 20px; left: 900px; padding: 15px; 
                border: 1px solid #12464c; border-radius: 8px; 
                background-color: #12464c; color: white; z-index: 9999;">
			<?php echo $_SESSION['alerta']; ?>
		</div>

		<script>
			// Mover la alerta al principio del <body>
			var alerta = document.getElementById("alerta");
			document.body.insertBefore(alerta, document.body.firstChild);

			// Ocultar la alerta después de 4 segundos
			setTimeout(function() {
				alerta.style.display = 'none';
			}, 4000); // 4000 milisegundos = 4 segundos
		</script>
	<?php
		unset($_SESSION['alerta']);
	}
	?>
	<!-- Fin Alerta PHP -->
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
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="user-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
					</li>
					<li>
						<a class="active" href="user-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
					<li>
						<a href="user-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								<th>TIPO DOCUMENTO</th>
								<th>NUMERO DE DOCUMENTO</th>
								<th>NOMBRE</th>
								<th>APELLIDO</th>
								<th>TELÉFONO</th>
								<th>EMAIL</th>
								<th>ESTADO</th>
								<th>ACTUALIZAR</th>
								<th>ELIMINAR</th>
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

							$objConUsuario = new ControladorUsuario();
							$res = $objConUsuario->mostrarUsuarios();

							while ($fila = $res->fetch_assoc()) {
							?>
								<tr class="text-center">
									<td><?= $fila['tip_doc_descripcion'] ?></td>
									<td><?= $fila['num_doc'] ?></td>
									<td><?= $fila['usu_nombres'] ?></td>
									<td><?= $fila['usu_apellidos'] ?></td>
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
																<div class="col-12 col-md-4">
																	<div class="form-group">
																		<label for="tipo_documento" class="bmd-label-floating">Tipo documento</label>
																		<select class="form-select" aria-label="Default select example" id="tipoDocumento" name="tipoDocumento" required>
																			<option value=""> Tipo de documento</option>
																			<?php
																			foreach ($tipoDoc as $filaT) { ?>
																				<option value="<?= $filaT['id_tipo_documento'] ?>" <?= ($filaT['id_tipo_documento'] == $fila['t_doc'] ? 'selected' : '') ?>><?= $filaT['tip_doc_descripcion'] ?></option>
																			<?php
																			}
																			?>
																		</select>
																	</div>
																</div>

																<div class="col-12 col-md-4">
																	<div class="form-group">
																		<label for="usuario_dni" class="bmd-label-floating">Numero de documento</label>
																		<input type="number" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni" id="usuario_dni" value="<?php echo $fila['num_doc'] ?>">
																	</div>
																</div>

																<div class="col-12 col-md-4">
																	<div class="form-group">
																		<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
																		<input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="<?php echo $fila['usu_nombres'] ?>" maxlength="60">
																	</div>
																</div>

																<div class="col-12 col-md-4">
																	<div class="form-group">
																		<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
																		<input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido" value="<?php echo $fila['usu_apellidos'] ?>" maxlength="40">
																	</div>
																</div>

																<div class="col-12 col-md-4">
																	<div class="form-group">
																		<label for="usuario_fecha_nacimiento" class="bmd-label-floating">Fecha de nacimiento</label>
																		<input type="date" class="form-control" name="usuario_fecha_nacimiento" id="usuario_fecha_nacimiento"
																			value="<?php echo date('Y-m-d', strtotime($fila['usu_fecha_nacimiento'])); ?>">
																	</div>
																</div>

																<div class="col-12 col-md-6">
																	<div class="form-group">
																		<label for="usuario_sexo" class="bmd-label-floating">sexo</label>
																		<input type="text" class="form-control" name="usuario_sexo" id="usuario_sexo" value="<?= $fila['usu_sexo'] ?>">
																	</div>
																</div>

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
															</div>
														</div>
													</fieldset>
													<br><br>
													<fieldset>
														<legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
														<div class="container-fluid">
															<div class="row">
																<div class="col-12 col-md-6">
																	<div class="form-group">
																		<label for="usuario_usuario" class="bmd-label-floating">Fecha contratacion</label>
																		<input type="date" class="form-control" name="usu_fecha_contratacion" id="usu_fecha_contratacion" value="<?php echo $fila['usu_fecha_contratacion'] ?>">
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
	<?php include '../Componentes/Script/script.php' ?>
</body>

</html>