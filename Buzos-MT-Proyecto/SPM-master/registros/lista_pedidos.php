<!DOCTYPE html>
<html lang="es">
<?php include '../Componentes/Head/head.php' ?>
<body>

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
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PEDIDOS
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="PPD.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PEDIDO</a>
					</li>
					<li>
						<a class="active" href="LP.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA
							DE PEDIDOS</a>
					</li>
					<li>
						<a href="PS.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PEDIDO</a>
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
								<th>FECHA DEL PEDIDO</th>
								<th>MONTO DEL PEDIDO</th>
								<th>ESTADO DEL PEDIDO</th>
								<th>ID DEL PAGO</th>
								<th>FECHA DEL PAGO</th>
								<th>MONTO DEL PAGO</th>
								<th>ESTADO PAGO</th>
								<th>DESEMPEÑO</th>
								<th>ACTUALIZAR</th>
								<th>ELIMINAR</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center">
								<td>1</td>
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>1</th>
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>EXCELENTE</th>
								<td>
									<a href="UP.html" class="btn btn-success">
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
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>2</th>
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>EXCELENTE</th>
								<td>
									<a href="UP.html" class="btn btn-success">
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
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>3</th>
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>EXCELENTE</th>
								<td>
									<a href="UP.html" class="btn btn-success">
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
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>4</th>
								<th>01-01-2024</th>
								<th>100000</th>
								<th>COMPLETADO</th>
								<th>EXCELENTE</th>
								<td>
									<a href="UP.html" class="btn btn-success">
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