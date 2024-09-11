<?php
session_start();
?>
<?php
require_once '../Controlador/ControladorUsuario.php';

include '../Config/variable_global.php';

include '../Componentes/Head/head.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<title>Actualizar Usuario</title>
</head>

<body>

	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<?php include '../Componentes/Sidebar/sidebar.php' ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<!-- Navbar -->
			<?php include '../Componentes/Navbar/navbar.php' ?>

			<div class="full-box page-header">
				<h3 class="text-left"><i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR DATOS</h3>
			</div>

			<div class="container-fluid">
				<form action="../Controlador/ControladorUsuario.php" method="POST" class="form-neon" autocomplete="off">
					<?php
					?>
					<input type="hidden" name="id" value="<?php echo $_POST['num_doc'] ?>">
					<fieldset>
						<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-2">
									<div class="form-group">
										<label for="tipo_documento" class="bmd-label-floating">Tipo documento</label>
										<select class="form-control" name="tipo_documento" id="tipo_documento">
											<option value="dni">Cédula de ciudadanía</option>
											<option value="pasaporte">Pasaporte</option>
											<option value="identidad">PPT</option>
										</select>
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_dni" class="bmd-label-floating">Numero de documento</label>
										<input type="number" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni" id="usuario_dni" maxlength="20" value="">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
										<input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="<?php echo $usuario['nombre']; ?>" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
										<input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido" value="<?php echo $usuario['apellido']; ?>" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_apellido" class="bmd-label-floating">Fecha de nacimiento</label>
										<input type="date" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido" id="usuario_apellido" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_telefono" class="bmd-label-floating">sexo</label>
										<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_telefono" id="usuario_telefono" maxlength="20">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
										<input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,190}" class="form-control" name="usuario_direccion" id="usuario_direccion" maxlength="190">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
										<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_telefono" id="usuario_telefono" maxlength="20">
									</div>
								</div>

							</div>
						</div>
					</fieldset>
					<br><br><br>
					<fieldset>
						<legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_usuario" class="bmd-label-floating">Fecha contratacion</label>
										<input type="date" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_usuario" id="usuario_usuario" maxlength="35">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_email" class="bmd-label-floating">Email</label>
										<input type="email" class="form-control" name="usuario_email" id="usuario_email" maxlength="70">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_clave_1" class="bmd-label-floating">Contraseña</label>
										<input type="password" class="form-control" name="usuario_clave_1" id="usuario_clave_1" maxlength="200">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_clave_2" class="bmd-label-floating">Repetir contraseña</label>
										<input type="password" class="form-control" name="usuario_clave_2" id="usuario_clave_2" maxlength="200">
									</div>
								</div>

								<!-- Otros campos -->

							</div>
						</div>
					</fieldset>
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-success btn-sm">
							<i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR
						</button>
					</p>
				</form>
			</div>
		</section>
	</main>

	<!-- JavaScript files -->
	<?php include '../Componentes/Script/script.php'; ?>
</body>

</html>