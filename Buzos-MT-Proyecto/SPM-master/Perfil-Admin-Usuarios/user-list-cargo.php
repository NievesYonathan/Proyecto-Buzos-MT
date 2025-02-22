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
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="cargos.php"><i class="fas fa-plus fa-fw"></i> &nbsp; CARGOS</a>
					</li>
					<li>
						<a class="active" href="user-list-cargo.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								<th>Tipo Documento</th>
								<th>Numero</th>
								<th>Nombre</th>
								<th>Cargo</th>
								<th>Añadir Cargo</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Consultar cargos una vez y almacenar en un array
							include_once "../Controlador/ControladorCarUsu.php";

							$objCarUsu = new ControladorCarUsu();
							$resCarUsu = $objCarUsu->consultarCarUsuarios();

							$carUsu = []; // Array para almacenar los cargos

							while ($filaCarUsu = $resCarUsu->fetch_assoc()) {
								$carUsu[] = $filaCarUsu; // Almacenar cada cargo en el array
							}

							// Consultar cargos una vez y almacenar en un array
							include_once "../Controlador/ControladorCargo.php";

							$objCargo = new ControladorCargo();
							$resCargos = $objCargo->getCargo();

							$cargos = []; // Array para almacenar los cargos

							while ($filaCargo = $resCargos->fetch_assoc()) {
								$cargos[] = $filaCargo; // Almacenar cada cargo en el array
							}

							include_once "../Controlador/ControladorUsuario.php";

							$objConUsuario = new ControladorUsuario();
							$res = $objConUsuario->mostrarUsuarios();

							while ($filaU = $res->fetch_assoc()) {
							?>
								<tr class="text-center">
									<td class="my-auto"><?= $filaU['tip_doc_descripcion'] ?></td>
									<td><?= $filaU['num_doc'] ?></td>
									<td><?= $filaU['usu_nombres'] ?></td>
									<td><?= $filaU['Cargos'] ?></td>
									<?php
									// Separar los cargos y estados en arrays
									// $cargosU = explode(',', $filaU['Cargos']);
									// $cargosEstado = explode(',', $filaU['estadoCargo']);

									// // Recorremos los estados y solo imprimimos los cargos cuyo estado sea "Activo"
									// for ($i = 0; $i < count($cargosEstado); $i++) {
									// 	if (trim($cargosEstado[$i]) == "Activo") {
									// 		echo "<td>" . $cargosU[$i] . "</td>";
									// 	}
									// }
									?>
									<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal<?= $filaU['num_doc'] ?>"><i class="fa-solid fa-user-plus"></i></button></td>
								</tr>
								<!-- Modal para agregar Cargos -->
								<div class="modal fade" id="addModal<?= $filaU['num_doc'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<form method="POST" action="../Controlador/ControladorCarUsu.php">
												<div class="modal-header">
													<h5 class="modal-title" id="addModalLabel">Agregar Cargos / <?= $filaU['num_doc'] ?></h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													<input type="hidden" value="<?= $filaU['num_doc'] ?>" name="numDoc">
												</div>
												<div class="modal-body">
													<div class="form-check form-switch">
														<?php
														if (!empty($cargos)) {
															foreach ($cargos as $cargo) {
																// Evitar errores asegurándonos de que las claves existen en el array $cargo
																if (isset($cargo['id_cargos']) && isset($cargo['car_nombre'])) {
																	$cargosUsuario = explode(',', $filaU['id_cargos']);
														?>
																	<input name="idCarUsuario[]" value="<?= $filaU['id_cargos'] ?>" type="hidden">
																	<input name="idCarUsuRel[]" value="<?= $filaU['id_usuario_cargo'] ?>" type="hidden">
																	<input class="form-check-input" name="idCargo[]" value="<?= $cargo['id_cargos'] ?>" type="checkbox" id="checkbox<?= $cargo['id_cargos'] ?>" <?= (in_array($cargo['id_cargos'], $cargosUsuario) ? 'checked' : '') ?>>
																	<label class="form-check-label" for="checkbox<?= $cargo['id_cargos'] ?>"><?= $cargo['car_nombre'] ?></label>
																	<br>
														<?php
																} else {
																	echo "Datos de cargo incompletos.";
																}
															}
														} else {
															echo "No hay cargos disponibles.";
														}
														?>
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary">Guardar</button>
												</div>
											</form>
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