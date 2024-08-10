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
					<i class="fab fa-dashcube fa-fw"></i> &nbsp; PRODUCCIÓN
				</h3>
				<!--<p class="text-justify">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
				</p>-->
			</div>
			
			<!-- Content -->
			
			
			<div class="full-box tile-container">
				<div class="pro-btns-resumen">
					<div class="pro-btns">
						<div class="pro-btn">
							<a href="#" class="pro-link">
								<i class="fa-solid fa-square-plus fa-2xl" style="color: #2baf54;"></i>
								<p>Crear Producción</p>
							</a>
						</div>				
						<div class="pro-btn">		
							<a href="#" class="pro-link">		
								<i class="fa-solid fa-file-circle-plus fa-2xl" style="color: #2baf54;"></i>
							</a>
							<div class="text-btn-link">
								<p>Añadir Tarea</p>
							</div>
						</div>				
					</div>
					<div class="pro-resumen">
						<h4>Resumen de Producción</h4>
						<div class="pro-res-detalle">
							<p>Producción: <span>Buzos Amarillos de Algodón</span></p>
							<p>Etapa: <span>2 - Armado de los patrones.</span></p>
							<a href="#" class="pro-ver">Ver Detalles</a>
						</div>
						<div class="pro-res-detalle">
							<p>Producción: <span>Buzos Amarillos de Algodón</span></p>
							<p>Etapa: <span>2 - Armado de los patrones.</span></p>
							<a href="#" class="pro-ver">Ver Detalles</a>
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