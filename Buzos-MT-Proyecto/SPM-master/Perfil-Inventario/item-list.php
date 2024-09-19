<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: ../login-registro/login.php');
}
?>
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
								<th>#</th>
								<th>NOMBRE</th>
								<th>STOCK</th>
								<th>ACTUALIZAR</th>
								<th>ELIMINAR</th>
                                <th>MOVIMIENTOS</th>
							</tr>
						</thead>
						<tbody>
                        <?php
                            $result = $contObj->consultarMateriaPrima();
                            while ($item = mysqli_fetch_object($result)) {
                            ?>
                                <tr class="text-center details">
                                    <td><?=$item->id_materia_prima?></td>
                                    <td><?=$item->mat_pri_nombre?></td>
                                    <td><?=$item->mat_pri_cantidad?></td>
                                    <td>
                                        <form action="item-update.php" method="post">
                                            <input type="hidden" name="matId" value="<?=$item->id_materia_prima?>">
                                            <input type="hidden" name="matNombre" value="<?=$item->mat_pri_nombre?>">
                                            <input type="hidden" name="matDescripcion" value="<?=$item->mat_pri_descripcion?>">
                                            <input type="hidden" name="matUnidad" value="<?=$item->mat_pri_unidad_medida?>">
                                            <input type="hidden" name="matCantidad" value="<?=$item->mat_pri_cantidad?>">
                                            <input type="hidden" name="matEstado" value="<?=$item->estado_id_estado?>">
                                            <input type="hidden" name="matFechaCompra" value="<?=$item->fecha_compra_mp?>">
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
                                    <td>
                                        <!-- Botón para abrir el modal -->
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#<?=$item->id_materia_prima?>">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </td>
                                </tr>                    
                            <!-- Modal -->
                                <div class="modal fade" id="<?=$item->id_materia_prima?>" tabindex="-1" aria-labelledby="movimientosLabel<?=$item->id_materia_prima?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="movimientosLabel<?=$item->id_materia_prima?>">Movimientos de: <?=$item->mat_pri_nombre.' - '.$item->id_materia_prima?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> 
                                            </div>       <!-- Aquí puedes agregar más movimientos dinámicamente si los tienes -->
                                        </div>
                                    </div>
                                </div>
                        <?php          
                            }   
                        ?>            
						</tbody>
					</table>
                </div>
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