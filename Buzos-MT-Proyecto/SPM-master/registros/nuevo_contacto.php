<!DOCTYPE html>
<html lang="es">
<?php include '../Componentes/Head/head.php' ?>
<body>

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
				<i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO CONTACTO
			</h3>
			<p class="text-justify">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae
				ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam
				ratione.
			</p>
		</div>

		<div class="container-fluid">
			<ul class="full-box list-unstyled page-nav-tabs">
				<li>
					<a class="active" href="NC.hmtl"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO
						CONTACTO</a>
				</li>
				<li>
					<a href="LC.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE
						CONTACTOS</a>
				</li>
				<li>
					<a href="US.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CONTACTO</a>
				</li>
			</ul>
		</div>

		<!-- Content -->
		<div class="container-fluid">
			<form action="" class="form-neon" autocomplete="off">
				<fieldset>
					<legend><i class="far fa-address-card"></i> &nbsp; Registro de Contactos de Proveedores</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="usuario_nombre" class="bmd-label-floating">Nombre del
										contacto</label>
									<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control"
										name="usuario_nombre" id="usuario_nombre" maxlength="35">
								</div>
							</div>

							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="usuario_apellido" class="bmd-label-floating">perfil</label>
									<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control"
										name="usuario_apellido" id="usuario_apellido" maxlength="35">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="usuario_apellido" class="bmd-label-floating">cargo del
										contacto</label>
									<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control"
										name="usuario_apellido" id="usuario_apellido" maxlength="35">
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="usuario_email" class="bmd-label-floating">correo Electrónico</label>
									<input type="email" class="form-control" name="usuario_email" id="usuario_email"
										maxlength="70">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
									<input type="text" pattern="[0-9()+]{1,20}" class="form-control"
										name="usuario_telefono" id="usuario_telefono" maxlength="20">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
									<input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,190}"
										class="form-control" name="usuario_direccion" id="usuario_direccion"
										maxlength="190">
								</div>
									<div class="form-group">
										<label for="usuario_nombre" class="bmd-label-floating">Adicional</label>
										<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control"
											name="usuario_nombre" id="usuario_nombre" maxlength="35">
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				<br><br><br>
				<p class="text-center" style="margin-top: 40px;">
					<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i>
						&nbsp; LIMPIAR</button>
					&nbsp; &nbsp;
					<button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp;
						GUARDAR</button>
				</p>
			</form>
		</div>



	</section>
	</main>


	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>

</html>