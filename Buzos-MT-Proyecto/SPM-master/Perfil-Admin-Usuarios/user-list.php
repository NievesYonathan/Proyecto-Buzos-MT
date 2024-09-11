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
							include_once "../Controlador/ControladorUsuario.php";

							$objConUsuario = new ControladorUsuario();
							$res = $objConUsuario->mostrarUsuarios();

							while ($fila = $res->fetch_assoc()) {
							?>
								<tr class="text-center">
									<form action="user-update.php" method="post">
										<td><?= $fila['t_doc'] ?></td>
										<th><?= $fila['num_doc'] ?></th>
										<th><?= $fila['usu_nombres'] ?></th>
										<th><?= $fila['usu_apellidos'] ?></th>
										<th><?= $fila['usu_telefono'] ?></th>
										<th><?= $fila['usu_email'] ?></th>
										<th><?= $fila['usu_estado'] ?></th>
										<td>
											<input type="hidden" name="t_doc" value="<?php echo $fila['t_doc'] ?>">
											<input type="hidden" name="num_doc" value="<?php echo $fila['num_doc'] ?>">
											<input type="hidden" name="usu_nombres" value="<?php echo $fila['usu_nombres'] ?>">
											<input type="hidden" name="usu_apellidos" value="<?php echo $fila['usu_apellidos'] ?>">
											<input type="hidden" name="usu_fecha_nacimiento" value="<?php echo $fila['usu_fecha_nacimiento'] ?>">
											<input type="hidden" name="usu_telefono" value="<?php echo $fila['usu_telefono'] ?>">
											<input type="hidden" name="usu_email" value="<?php echo $fila['usu_email'] ?>">
											<input type="hidden" name="usu_estado" value="<?php echo $fila['usu_estado'] ?>">
											<input type="hidden" name="usu_fecha_contratacion" value="<?php echo $fila['usu_fecha_contratacion'] ?>">
											<input type="hidden" name="usu_sexo" value="<?php echo $fila['usu_sexo'] ?>">
											<input type="hidden" name="usu_direccion" value="<?php echo $fila['usu_direccion'] ?>">


											<button type="submit" class="btn btn-success">
												<i class="fas fa-sync-alt"></i>
											</button>
									</form>
									</td>
									<td>
										<form action="">
											<button type="button" class="btn btn-warning">
												<i class="far fa-trash-alt"></i>
											</button>
										</form>
									</td>
								</tr>
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