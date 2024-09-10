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
								<th>Añadir Cargo</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include_once "../Controlador/ControladorUsuario.php";

							$objConUsuario = new ControladorUsuario();
							$res = $objConUsuario->mostrarUsuarios();

							while ($fila = $res->fetch_assoc()) {
							?>
								<tr class="text-center">
									<td><?= $fila['tip_doc_descripcion'] ?></td>
									<th><?= $fila['num_doc'] ?></th>
									<th><?= $fila['usu_nombres'] ?></th>
									<th><button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addModal<?= $fila['num_doc'] ?>">ADD</button></th>
								</tr>
								<!-- Modal para agregar Cargos -->
								<div class="modal fade" id="addModal<?= $fila['num_doc'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<form method="POST" action="../Controlador/ControladorCargo.php">
												<div class="modal-header">
													<h5 class="modal-title" id="addModalLabel">Agregar Cargos / <?= $fila['num_doc'] ?></h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<div class="form-check form-switch">
														<?php
														include_once "../Controlador/ControladorCargo.php";

														$objCargo = new ControladorCargo();
														$res = $objCargo->getCargo();

														while ($fila = $res->fetch_assoc()) {
														?>
															<input class="form-check-input" value="<?= $fila['id_cargos'] ?>" type="checkbox" role="switch" id="checkbox<?= $fila['id_cargos'] ?>">
															<label class="form-check-label" for="checkbox<?= $fila['id_cargos'] ?>"><?= $fila['car_nombre'] ?></label>
														<?php
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