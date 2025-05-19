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
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM
                </h3>
            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a href="item-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
                    </li>
                    <li>
                        <a href="item-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
                    </li>
                    <li>
                        <a class="active" href="item-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
                    </li>
                </ul>
            </div>
            
            <!--CONTENT-->
            <div class="container-fluid">
                <form class="form-neon" action="item-search.php" method="post">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="inputSearch" class="bmd-label-floating">¿Qué item estas buscando?</label>
                                    <input type="text" class="form-control" name="busqueda" id="inputSearch" maxlength="30">
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-center" style="margin-top: 40px;">
                                    <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                                </p>
                            </div>
                            <div class="col-12">
                                <p class="text-center">
                                <button type="submit" class="btn btn-raised btn-danger" value="eliminarBusqueda"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="container-fluid">
                <form action="../Controlador/ControladorMateriasP.php" method="Post">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                    <?php if(!empty($_POST['eliminarBusqueda'])){
                                        echo '<p class="text-center" style="font-size: 20px;">
                                        Los resultados a tu busqueda <strong>"'.$_POST['busqueda'].'"</strong>
                                        </p>';
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


           <div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium"> 
								<th>#</th>
								<th>NOMBRE</th>
								<th>STOCK</th>
								<th>ACTUALIZAR</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                            $result = $contObj->buscarMateriaPri();
                            while ($item = mysqli_fetch_object($result)){ ?>
							<tr class="text-center" >
                                <td><?=$item->id_materia_prima?></td>
                                <td><?=$item->mat_pri_nombre?></td>
                                <td><?=$item->mat_pri_cantidad?></td>
								<td>
                                    <a href="item-update.php" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i> 
                                    </a>
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