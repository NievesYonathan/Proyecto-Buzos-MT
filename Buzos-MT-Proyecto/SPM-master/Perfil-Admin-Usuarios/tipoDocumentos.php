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
					<i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR CARGOS
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="cargos.php"><i class="fas fa-plus fa-fw"></i> &nbsp; CARGOS</a>
					</li>
					<li>
						<a href="user-list-cargo.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<form action="../Controlador/ControladorCargo.php" method="POST" class="form-neon" autocomplete="off">
					<fieldset>
						<legend><i class="fas fa-user-lock"></i> &nbsp; Registrar Cargos del Sistema</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="cargo_sistema" class="bmd-label-floating">Nombre del Cargo</label>
										<input type="text" class="form-control" name="cargo_sistema" id="cargo_sistema">
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

				<br>

				<div class="form-neon mt-20">
					<legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de Cargos del Sistema</legend>
					<!-- Elimina el punto de la lista -->
					<style>
						ul {
							list-style-type: none;
						}
					</style>
					<ul>
						<?php
						include_once '../Controlador/ControladorCargo.php';
						$cargo = new ControladorCargo();
						$res = $cargo->getCargo();

						while ($fila = mysqli_fetch_assoc($res)) {
							echo '<li><i class="fas fa-check-circle"></i> ' . $fila['car_nombre'] . ' 
									<button data-bs-toggle="modal" data-bs-target="#updateModal' . $fila['id_cargos'] . '">
										<i class="fa-regular fa-pen-to-square"></i>
									</button>
								   </li>';
						?>
							<!-- Modal para editar usuarios -->
							<div class="modal fade" id="updateModal<?= $fila['id_cargos'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="../Controlador/ControladorCargo.php" method="post">
												<input type="hidden" name="id" value="<?= $fila['id_cargos'] ?>">
												<fieldset>
													<legend><i class="far fa-address-card"></i> &nbsp; Editar Cargo</legend>
													<div class="container-fluid">
														<div class="row">

															<div class="col-12 col-md-12">
																<div class="form-group">
																	<label for="usuario_nombre" class="bmd-label-floating">Nombre</label>
																	<input type="text" class="form-control" name="car_nombre" id="usuario_nombre" value="<?php echo $fila['car_nombre'] ?>" maxlength="60">
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
					</ul>
				</div>
			</div>
		</section>
	</main>


	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>

</html>