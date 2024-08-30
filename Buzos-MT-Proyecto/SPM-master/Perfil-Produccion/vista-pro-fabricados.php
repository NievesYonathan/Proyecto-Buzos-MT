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
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; Gestion Productos Fabricados
				</h3>
			</div>
			
			<!-- Content -->
			<div class="full-box tile-container">

				<div class="product-list">
					<div class="product-item">
						<img src="https://lh5.googleusercontent.com/proxy/qSbTXu5kBnkHZvxBc4fhU1Kktwp1fUcrVFklTH2NUaIUIhfKOyxVhKMPIUxODR77A-ZDMH2huxyrPifk4rLoy-zprigwgZ0CnQriaumBm0bpFjUlphotjuZ4PWsc2G-LBOSJDQNznsi9r_o1rVhK6Jh0k6liF3c" alt="Producto" class="product-image">
						<div class="product-info">
							<h3 class="product-name">Buzos unixes</h3>
							<p class="product-quantity">Cantidad de Producción: 500 unidades</p>
							<p class="product-dates">Fecha de Inicio: 01/08/2024 - Fecha de Fin: 15/08/2024</p>
							<p class="product-status">Estado: En curso</p>
							<p class="product-material">Material: Algodón</p>
							<div class="product-actions">
								<button class="btn btn-info">Ver Detalles</button>
							</div>
						</div>
					</div>
				</div>			
			</div>
			

		</section>
	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>

</body>
</html>