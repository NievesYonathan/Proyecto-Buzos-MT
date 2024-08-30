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
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORMES Y REPORTES
                </h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum delectus eos enim numquam fugit optio accusantium, aperiam eius facere architecto facilis quibusdam asperiores veniam omnis saepe est et, quod obcaecati.
                </p>
            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a href="informes.php"><i class="fas fa-plus fa-fw"></i> &nbsp; INFORME INVENTARIO</a>
                    </li>
                    <li>
                        <a class="active" href="info-produccion.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORME PRODUCCION</a>
                    </li>
                    <li>
                        <a href="info-Rec.Humanos.php"><i class="fas fa-search fa-fw"></i> &nbsp; INFORME RECURSOS HUMANOS</a>
                    </li>
                </ul>
            </div>
            
            <!--CONTENT-->
            <div class="container-fluid tile-container">
				<div class="col-12 col-md-4">
					<div class="form-group">
						<label for="prestamo_fecha_inicio">Seleccione la Fecha</label>
						<input type="date" class="form-control" name="prestamo_fecha_inicio" id="admin-dni">
					</div>
            	</div>

            	<h4 class="text-left"><i class="fas fa-calendar-check"></i> &nbsp; Datos de produccion de la fecha: 07/08/2024</h4>

				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								<th>#</th>
								<th>CÓDIGO</th>
								<th>NOMBRE DEL PRODUCTO</th>
								<th>CANTIDAD DE PROD. COMPLETADOS</th>
								<th>CANTIDAD DE PROD. EN PROCESO</th>
                                <th>TOTAL ESTIMADO</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center" >
								<td>1</td>
								<td>012342567</td>
								<td>BUZO</td>
								<td>700</td>
								<td>300</td>
                                <td>1000</td>
							</tr>

							<tr class="text-center" >
								<td>2</td>
								<td>012342567</td>
								<td>SUDADERA</td>
								<td>400</td>
								<td>100</td>
                                <td>500</td>
							</tr>

							<tr class="text-center" >
								<td>3</td>
								<td>012342567</td>
								<td>BUZO CON CAPUCHA</td>
								<td>150</td>
								<td>150</td>
                                <td>300</td>
							</tr>

							<tr class="text-center" >
								<td>4</td>
								<td>012342567</td>
								<td>BUZO CON BOLSILLOS</td>
								<td>250</td>
								<td>75</td>
                                <td>325</td>
							</tr>

                            <tr class="text-center" >
								<td>5</td>
								<td>012342567</td>
								<td>BUZO SIN CAPUCHA</td>
								<td>350</td>
								<td>0</td>
                                <td>350</td>
							</tr>

                            <tr class="text-center" >
								<td>6</td>
								<td>012342567</td>
								<td>BUZO SIN BOLSILLOS</td>
								<td>450</td>
								<td>20</td>
                                <td>470</td>
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