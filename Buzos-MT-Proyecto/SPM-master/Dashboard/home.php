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
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; DASHBOARD
				</h3>
				<!-- <p class="text-justify">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
				</p> -->
			</div>
			
			<!-- Content -->
			<div class="full-box tile-container">

				<a href="client-new.html" class="tile">
					<div class="tile-tittle">Producción</div>
					<div class="tile-icon">
						<i class="fa-solid fa-industry"></i>
						<!-- <p>5 Registrados</p> -->
					</div>
				</a>

				<a href="item-list.html" class="tile">
					<div class="tile-tittle">Materia Prima</div>
					<div class="tile-icon">
						<i class="fas fa-pallet fa-fw"></i>
						<!-- <p>9 Registrados</p> -->
					</div>
				</a>

				<!-- <a href="reservation-list.html" class="tile">
					<div class="tile-tittle">Prestamos</div>
					<div class="tile-icon">
						<i class="fas fa-file-invoice-dollar fa-fw"></i>
						<p>10 Registrados</p>
					</div>
				</a> -->

				<a href="user-list.html" class="tile">
					<div class="tile-tittle">Usuarios</div>
					<div class="tile-icon">
						<i class="fa-solid fa-user fa-fw"></i>
						<!-- <p>50 Registrados</p> -->
					</div>
				</a>

				<!-- <a href="company.html" class="tile">
					<div class="tile-tittle">Empresa</div>
					<div class="tile-icon">
						<i class="fas fa-store-alt fa-fw"></i>
						<p>1 Registrada</p>
					</div>
				</a> -->
				
			</div>
			

		</section>
	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>

</body>
</html>