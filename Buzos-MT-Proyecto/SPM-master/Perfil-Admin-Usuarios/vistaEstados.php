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
					<i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR ESTADOS
				</h3>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<form action="../Controlador/ControladorEstado.php" method="POST" class="form-neon" autocomplete="off">
					<fieldset>
						<legend><i class="fas fa-user-lock"></i> &nbsp; Registrar Estados</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-12">
									<div class="form-group">
										<label for="nombreEst" class="bmd-label-floating">Ingrese el tipo de estado</label>
										<input type="text" class="form-control" name="nombreEst" id="nombreEst">
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
						&nbsp; &nbsp;
						<button type="submit" name="Accion" value="Crear" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
					</p>
				</form>

				<br>

				<div class="form-neon mt-20">
					<legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de Tipos de Documentos</legend>
					<!-- Elimina el punto de la lista -->
					<style>
						ul {
							list-style-type: none;
						}
					</style>
					<ul>
						<?php
						include_once '../Controlador/ControladorEstado.php';
						$tDoc = new ControladorEstado();
						$res = $tDoc->getEstado();

						while ($fila = mysqli_fetch_assoc($res)) {
							echo '<li class="mb-2"><i class="fas fa-check-circle"></i> ' . $fila['nombre_estado'] . ' 
									<button data-bs-toggle="modal" data-bs-target="#updateModal' . $fila['id_estados'] . '">
										<i class="fa-regular fa-pen-to-square"></i>
									</button>
								   </li>';
						?>
							<!-- Modal para editar usuarios -->
							<div class="modal fade" id="updateModal<?= $fila['id_estados'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="../Controlador/ControladorEstado.php" method="post">
												<input type="hidden" name="id" value="<?= $fila['id_estados'] ?>">
												<fieldset>
													<legend><i class="far fa-address-card"></i> &nbsp; Editar Cargo</legend>
													<div class="container-fluid">
														<div class="row">

															<div class="col-12 col-md-12">
																<div class="form-group">
																	<label for="nombreEst" class="bmd-label-floating">Nombre</label>
																	<input type="text" class="form-control" name="nombreEst" id="nombreEst" value="<?php echo $fila['nombre_estado'] ?>" maxlength="60">
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