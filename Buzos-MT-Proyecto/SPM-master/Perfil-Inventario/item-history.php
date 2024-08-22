<!DOCTYPE html>
<html lang="es">
	<?php include '../Componentes/Head/head.php' ?>
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
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; DETALLES DE PRODUCTO
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
                            <th>FECHA</th>
                            <th>HORA</th>
                            <th>TIPO DE OPERACION</th>
                            <th colspan="2">CANTIDAD</th>
                            <th>USUARIO</th>
                        </tr>
                        <tr class="text-center roboto-medium">
                            <th></th> <!-- Celda vacía para FECHA -->
                            <th></th> <!-- Celda vacía para HORA -->
                            <th></th> <!-- Celda vacía para TIPO DE OPERACION -->
                            <th>ANTES</th>
                            <th>DESPUES</th>
                            <th></th> <!-- Celda vacía para USUARIO -->
                        </tr>
                    </thead>

						<tbody>
							<tr class="text-center" >
								<td>29-01-2023</td>
								<td>15-30-00</td>
								<td>ENTRADA</td>
								<td>30</td>
								<td>30</td>
                                <td>HAROLD</td>
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