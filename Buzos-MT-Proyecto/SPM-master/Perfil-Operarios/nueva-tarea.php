<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php
include '../Config/variable_global.php';
include '../Componentes/Head/head.php' ?>

<body>

	<!-- Inicio Alerta PHP -->
	<?php
	if (isset($_SESSION['alerta'])) {
	?>
		<div id="alerta" class="alert alert-info" role="alert"
			style="position: fixed; top: 20px; left: 20px; padding: 15px; 
                border: 1px solid #12464c; border-radius: 8px; 
                background-color: #12464c; color: white; z-index: 9999;">
			<?php echo $_SESSION['alerta']; ?>
		</div>

		<script>
			// Mover la alerta al principio del <body>
			var alerta = document.getElementById("alerta");
			document.body.insertBefore(alerta, document.body.firstChild);

			// Ocultar la alerta después de 4 segundos
			setTimeout(function() {
				alerta.style.display = 'none';
			}, 4000); // 4000 milisegundos = 4 segundos
		</script>
	<?php
		unset($_SESSION['alerta']);
	}
	?>
	<!-- Fin Alerta PHP -->

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
					<i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA TAREA
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="nueva-tarea.php"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVA TAREA</a>
					</li>
					<li>
						<a href="lista-tareas.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE TAREAS</a>
					</li>
					<li>
						<a href="buscar-tarea.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR TAREA</a>
					</li>
				</ul>
			</div>

			<!-- Formulario de Nueva Tarea -->
			<div class="container-fluid">
				<form method="post" action="../Controlador/ControladorTarea.php">

					<fieldset>
						<legend><i class="far fa-clipboard"></i> &nbsp; Detalles de la Tarea</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="nombreTarea" class="bmd-label-floating">Nombre de la Tarea</label>
										<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" name="nombreTarea" id="nombreTarea" maxlength="50">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="descripcionTarea" class="bmd-label-floating">Descripción</label>
										<textarea class="form-control" name="descripcionTarea" id="descripcionTarea" maxlength="250" rows="3"></textarea>
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="estadoTarea" class="bmd-label-floating">Estado</label>
										<select class="form-control" name="estadoTarea" id="estadoTarea">
											<option value="Pendiente">Pendiente</option>
											<option value="En Progreso">En Proceso</option>
											<option value="Completada">Completada</option>
										</select>
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="plazoEntrega" class="bmd-label-floating">Plazo de Entrega</label>
										<input type="date" class="form-control" name="plazoEntrega" id="plazoEntrega">
									</div>
								</div>
							</div>
						</div>
					</fieldset>

					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
						&nbsp; &nbsp;
						<button type="submit" class="btn btn-raised btn-info btn-sm" name="accion" value="guardar"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
					</p>
				</form>
			</div>

		</section>
	</main>

	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>

</html>
