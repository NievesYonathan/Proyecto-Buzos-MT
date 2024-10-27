<?php
session_start();

if(!isset($_SESSION['user_id'])){
	header('Location: ../Login-Registro/login.php');
}

?>
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

				<?php
				$perfil = $_SESSION['user_cargo'];

				//Enlace solo visible para Jefe de Producción
				if ($perfil == 'Jefe Producción'): ?>
					<a href="../Perfil-Produccion/vista-produccion.php" class="tile">
						<div class="tile-tittle">Producción</div>
						<div class="tile-icon">
							<i class="fa-solid fa-industry"></i>
						</div>
					</a>
					
					<a href="../Perfil-Produccion/vista-pro-fabricados.php" class="tile">
						<div class="tile-tittle">Detalles de Producción</div>
						<div class="tile-icon">
							<i class="fa-solid fa-shirt"></i>
						</div>
					</a>

					<a href="../Informes/info-produccion.php" class="tile">
						<div class="tile-tittle">Informes</div>
						<div class="tile-icon">
							<i class="fa-solid fa-file-circle-plus"></i>
						</div>
					</a>
				<?php endif; ?>


				<?php 
				//Enlace solo visible para Jefe de Inventario
				if ($perfil == 'Jefe Inventario'): ?>
					<a href="../Perfil-Inventario/item-list.php" class="tile">
						<div class="tile-tittle">Materia Prima</div>
						<div class="tile-icon">
							<i class="fas fa-pallet fa-fw"></i>
						</div>
					</a>
				<?php endif; ?>

				<?php 
				//Enlace solo visible para Administrador de usuario
				if ($perfil == 'Administrador Usuario'): ?>
					<a href="../Perfil-Admin-Usuarios/user-list.php" class="tile">
						<div class="tile-tittle">Usuarios</div>
						<div class="tile-icon">
							<i class="fa-solid fa-user fa-fw"></i>
						</div>
					</a>
					
					<a href="../Perfil-Operarios/nueva-tarea.php" class="tile">
						<div class="tile-tittle">Tareas</div>
						<div class="tile-icon">
						<i class="fa-solid fa-calendar-days"></i>
						</div>
					</a>
				<?php endif; ?>

				<?php
				//Enlace solo visible para Operario
				if ($perfil == 'Operario'): ?>
					<a href="../Perfil-Operarios/vista-tar-asignadas.php" class="tile">
						<div class="tile-tittle">Mis Tareas</div>
						<div class="tile-icon">
						<i class="fa-brands fa-stack-exchange"></i>
						</div>
					</a>
				<?php endif; ?>

			</div>
		</section>
	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>

</body>
</html>