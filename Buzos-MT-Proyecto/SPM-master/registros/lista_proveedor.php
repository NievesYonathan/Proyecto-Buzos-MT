<!DOCTYPE html>
<html lang="es">
<?php include '../Componentes/Head/head.php' ?>
<body>

		<!-- Nav lateral -->
		<?php include '../Componentes/Sidebar/sidebar.php' ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<!-- Navbar -->
			<?php include '../Componentes/Navbar/navbar.php' ?>

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
								<th>#</th>
								<th>nombre de la empresa</th>
								<th>direccion de la empresa</th>
								<th>materiales</th>
								<th>TELÉFONO</th>
								<th>nombre de contacto</th>
								<th>correo electronico</th>
								<th>ACTUALIZAR</th>
								<th>ELIMINAR</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center">
								<td>1</td>
								<th>NOMBRE DE LA EMPERSA</th>
								<th>DIRECCION DE LA EMPRESA</th>
								<th>MATERIAL SUMINISTRADO POR LA EMPRESA</th>
								<th>1234567890</th>
								<th>NOMBRE DE CONTACTO</th>
								<th>ADMIN@ADMIN.COM</th>
								<td>
									<a href="UPP.html" class="btn btn-success">
										<i class="fas fa-sync-alt"></i>
									</a>
								</td>
								<td>
									<form action="">
										<button type="button" class="btn btn-warning">
											<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>
							<tr class="text-center">
								<td>2</td>
								<th>NOMBRE DE LA EMPERSA</th>
								<th>DIRECCION DE LA EMPRESA</th>
								<th>MATERIAL SUMINISTRADO POR LA EMPRESA</th>
								<th>1234567890</th>
								<th>NOMBRE DE CONTACTO</th>
								<th>ADMIN@ADMIN.COM</th>
								<td>
									<a href="UPP.html" class="btn btn-success">
										<i class="fas fa-sync-alt"></i>
									</a>
								</td>
								<td>
									<form action="">
										<button type="button" class="btn btn-warning">
											<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>
							<tr class="text-center">
								<td>3</td>
								<th>NOMBRE DE LA EMPERSA</th>
								<th>DIRECCION DE LA EMPRESA</th>
								<th>MATERIAL SUMINISTRADO POR LA EMPRESA</th>
								<th>1234567890</th>
								<th>NOMBRE DE CONTACTO</th>
								<th>ADMIN@ADMIN.COM</th>
								<td>
									<a href="UPP.html" class="btn btn-success">
										<i class="fas fa-sync-alt"></i>
									</a>
								</td>
								<td>
									<form action="">
										<button type="button" class="btn btn-warning">
											<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>
							<tr class="text-center">
								<td>4</td>
								<th>NOMBRE DE LA EMPRESA</th>
								<th>DIRECCION DE LA EMPRESA</th>
								<th>MATERIAL SUMINISTRADO POR LA EMPRESA</th>
								<th>1234567890</th>
								<th>NOMBRE DE CONTACTO</th>
								<th>ADMIN@ADMIN.COM</th>
								<td>
									<a href="UPP.html" class="btn btn-success">
										<i class="fas fa-sync-alt"></i>
									</a>
								</td>
								<td>
									<form action="">
										<button type="button" class="btn btn-warning">
											<i class="far fa-trash-alt"></i>
										</button>
									</form>
								</td>
							</tr>
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