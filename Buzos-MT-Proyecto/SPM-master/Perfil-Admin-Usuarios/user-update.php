<?php
//session_start();
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
				<form method="post" action="../Controlador/ControladorUsuario.php">

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
										<input type="number" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni" id="usuario_dni" maxlength="20" value="<?php echo $_POST['num_doc'] ?>">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
										<input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_POST['usu_nombres'] ?>" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
										<input type="text" class="form-control" name="usuario_apellido" id="usuario_apellido" value="<?php echo $_POST['usu_apellidos'] ?>" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_apellido" class="bmd-label-floating">Fecha de nacimiento</label>
										<input type="date" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_fecha_nacimiento" id="usuario_fecha_nacimiento" maxlength="35" value="<?php echo $_POST['usu_fecha_nacimiento'] ?>">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_telefono" class="bmd-label-floating">sexo</label>
										<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_sexo" id="usuario_sexo" maxlength="20" value="<?php echo $_POST['usu_sexo'] ?>">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
										<input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,190}" class="form-control" name="usuario_direccion" id="usuario_direccion" maxlength="190" value="<?php echo $_POST['usu_direccion'] ?>">
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
										<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_telefono" id="usuario_telefono" maxlength="20" value="<?php echo $_POST['usu_telefono'] ?>">
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
										<input type="date" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usu_fecha_contratacion" id="usu_fecha_contratacion" maxlength="35">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_email" class="bmd-label-floating">Email</label>
										<input type="email" class="form-control" name="usuario_email" id="usuario_email" maxlength="70" >
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
									<label for="password">Contraseña:</label>
									<input type="password" name="password" id="password" required>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
									<label for="confirm_password">Confirmar Contraseña:</label>
									<input type="password" name="confirm_password" id="confirm_password" required>
									</div>
								</div>

								<!-- Otros campos -->

							</div>
						</div>
					</fieldset>
					<td>
						<p class="text-center" style="margin-top: 40px;">
							<button type="submit" name="Accion" name="Actualizar" class="btn btn-raised btn-success btn-sm">
								<i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR
							</button>
						</p>
					</td>

					
				</form>
			</div>
		</section>
	</main>

	<!-- JavaScript files -->
	<?php include '../Componentes/Script/script.php'; ?>
</body>

</html>