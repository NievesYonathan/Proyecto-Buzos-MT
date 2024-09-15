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
					<i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR CARGOS
				</h3>
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="cargos.php"><i class="fas fa-plus fa-fw"></i> &nbsp; CARGOS</a>
					</li>
					<li>
						<a href="user-list-cargo.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
				</ul>	
			</div>
			
			<!-- Content -->
			<div class="container-fluid">
				<form action="../Controlador/ControladorCargo.php" method="POST" class="form-neon" autocomplete="off">
					<fieldset>
						<legend><i class="fas fa-user-lock"></i> &nbsp; Registrar Cargos del Sistema</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="cargo_sistema" class="bmd-label-floating">Nombre del Cargo</label>
										<input type="text" class="form-control" name="cargo_sistema" id="cargo_sistema">
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
						&nbsp; &nbsp;
						<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
					</p>
				</form>
<br>
				<div class="form-neon mt-20">
				<legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de Cargos del Sistema</legend>
					<!-- Elimina el punto de la lista --><style>ul {list-style-type: none; }</style>
<ul>
    <?php
    include_once '../Modelo/Conexion.php';
    $conexion = new Conexion();
    $conectarse = $conexion->conectarse();

    $sql = "SELECT * FROM cargos";
    $stmt = $conectarse->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conectarse->close();

    while($fila = mysqli_fetch_assoc($res)) {
        echo "<li><i class='fas fa-check-circle'></i> " . $fila['car_nombre'] . "</li>";
    }
    ?>
</ul>
				</div>
			</div>
			

		</section>
	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>
</html>