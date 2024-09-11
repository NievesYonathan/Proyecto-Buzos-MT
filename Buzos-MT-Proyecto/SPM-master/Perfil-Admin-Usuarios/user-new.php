<!DOCTYPE html>
<html lang="es">
	<?php 
	include '../Config/variable_global.php';

	include '../Componentes/Head/head.php' ?>

<body>
	
<!-- Inicio Alerta PHP -->
<?php
if(isset($_SESSION['alerta'])) {
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
					<i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO
				</h3>
				<p class="text-justify">

				</p>
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="../Login-Registro/registros.php"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
					</li>
					<li>
						<a href="user-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
					<li>
						<a href="user-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
					</li>
				</ul>	
			</div>
			
			<!-- Content -->
			<div class="container-fluid">
					<fieldset>
						<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="tipo_documento" class="bmd-label-floating">Tipo documento</label>
										<select class="form-control" name="tipo_documento" id="tipo_documento">
										<?php
                                        include_once '../Modelo/Conexion.php';
										include "../Controlador/registroPersona.php";
                                        $conexion = new Conexion();
                                        $conectarse = $conexion->conectarse();
                    
                                        $sql = "SELECT * FROM tipo_doc";
                                        $res = $conectarse->query($sql);
                                        $conectarse->close();
                    
                                        while($fila = mysqli_fetch_assoc($res)) { ?>                                      
                                            <option value="<?= $fila['id_tipo_documento'] ?>"><?= $fila['tip_doc_descripcion'] ?></option>
                                        <?php
                                        }
                                        ?>
										</select>
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_dni" class="bmd-label-floating">Numero de documento</label>
										<input type="number" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni" id="usuario_dni" maxlength="20">
									</div>
								</div>
								
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
										<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre" id="usuario_nombre" maxlength="35">
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
										<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido" id="usuario_apellido" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usu_fecha_nac" class="bmd-label-floating">Fecha de nacimiento</label>
										<input type="date" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="Fecha_nacimiento" id="usuario_apellido" maxlength="35">
									</div>
								</div>

								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="sexo" class="bmd-label-floating">sexo</label>
										<select class="form-control" name="sexo" id="sexo">
										<option value="">Sexo</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                        </select>
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
										<label for="usu_fecha_contratacion" class="bmd-label-floating">Fecha contratacion</label>
										<input type="date" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usu_fecha_contratacion" id="usu_fecha_contratacion" maxlength="35">
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
							</div>
						</div>
					</fieldset>
					<br><br><br>
					<!-- priviliegios <fieldset>
						<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12">
									<p><span class="badge text-bg-info">Control total</span> Permisos para registrar, actualizar y eliminar</p>
									<p><span class="badge text-bg-success">Edición</span> Permisos para registrar y actualizar</p>
									<p><span class="badge text-bg-dark">Registrar</span> Solo permisos para registrar</p>
									<div class="form-group">
										<select class="form-control" name="usuario_privilegio">
											<option value="" selected="" disabled="">Seleccione una opción</option>
											<option value="1">Control total</option>
											<option value="2">Edición</option>
											<option value="3">Registrar</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</fieldset> -->
					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
						&nbsp; &nbsp;
						<button type="submit" class="btn btn-raised btn-info btn-sm" name="btnguardar" ><i class="far fa-save"> </i> &nbsp; GUARDAR</button>
					</p>
				</form>
			</div>
			
		</section>
	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>
</html>