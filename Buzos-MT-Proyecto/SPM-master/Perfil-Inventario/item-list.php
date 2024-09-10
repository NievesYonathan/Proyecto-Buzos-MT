<!DOCTYPE html>
<html lang="es">
	<?php 
    include_once '../Controlador/ControladorMateriasP.php';
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
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS
                </h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum delectus eos enim numquam fugit optio accusantium, aperiam eius facere architecto facilis quibusdam asperiores veniam omnis saepe est et, quod obcaecati.
                </p>
            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a href="item-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
                    </li>
                    <li>
                        <a class="active" href="item-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
                    </li>
                    <li>
                        <a href="item-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
                    </li>
                </ul>
            </div>
            
            <!--CONTENT-->
           <div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								
								<th>CÓDIGO</th>
								<th>NOMBRE</th>
								<th>STOCK</th>
								<th>ESTADO</th>
								<th>ACTUALIZAR</th>
								<th>ELIMINAR</th>
                                <th>MOVIMIENTOS</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center details" >
                                <?php //bucle de la materia prima
                                $objConsul = new ControladorMateriaPrima();
								$result = $objConsul->consultarMateriaPrima();
                                while ($row = mysqli_fetch_assoc($result)) {
                                echo '<td>'. $row['id_materia_prima'].'</td>
								<td>'.$row['mat_pri_nombre'].'</td>
								<td>'.$row['mat_pri_cantidad'].'</td>
								<td>'.$row['mat_pri_estado'].'</td>
								<td>
                                    <a href="item-update.php" class="btn btn-success">
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
                                <td>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#movimientosItems">
                                        <i class="fa-solid fa-clock-rotate-left"></i> 
                                    </button>
                                </td>
							</tr>';
                            
                                }
							?>
							<div class="modal fade" id="movimientosItems" tabindex="-1" role="dialog" data-bs-backdrop="static">
						<div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
							<div class="modal-content">

								<div class="modal-header">
									<h5 class="modal-title">Detalles de Producción:</h5>
									<button class="btn-close" data-bs-dismiss="modal"></button>
								</div>
								
								<div class="modal-body">
									
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button> 
								</div>
							</div>
						</div>
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
    
    	
	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<!-- jQuery V3.4.1 -->
	<script src="../js/jquery-3.4.1.min.js" ></script>

	<!-- popper -->
	<script src="../js/popper.min.js" ></script>

	<!-- Bootstrap V4.3 -->
	<script src="../js/bootstrap.min.js" ></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="../js/jquery.mCustomScrollbar.concat.min.js" ></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="../js/bootstrap-material-design.min.js" ></script>
	<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

	<script src="../js/main.js" ></script>
</body>
</html>