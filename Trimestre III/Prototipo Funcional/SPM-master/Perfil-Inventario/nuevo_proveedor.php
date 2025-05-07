<!DOCTYPE html>
<html lang="es">
	<?php 
	include '../Config/variable_global.php';

	include '../Componentes/Head/head.php' ?>

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
					<i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PROVEEDOR
				</h3>
			</div>
			
			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="CPP.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PROVEEDOR</a>
					</li>
					<li>
						<a href="LPP.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PROVEEDORES</a>
					</li>
					<li>
						<a href="PPS.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PROVEEDOR</a>
					</li>
				</ul>	
			</div>
			
			 <!-- Content -->
			<div class="container-fluid">
				<form action="" class="form-neon" autocomplete="off">
					<fieldset>
						<legend><i class="far fa-address-card"></i> &nbsp; proveedores de materiales</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_nombre_empresa" class="bmd-label-floating">Nombre de la empresa</label>
										<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre_empresa" id="usuario_nombre_empresa" maxlength="35">
									</div>
								</div>
								
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_direccion_empresa" class="bmd-label-floating">direccion de la empresa</label>
										<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_direccion_empresa" id="usuario_direccion_empresa" maxlength="35">
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="usuario_ciudad" class="bmd-label-floating">materiales</label>
										<input type="text" class="form-control" name="usuario_ciudad" id="usuario_ciudad" maxlength="70">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
										<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_telefono" id="usuario_telefono" maxlength="20">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="usuario_nombre_contacto" class="bmd-label-floating">nombre del contacto</label>
										<input type="text" pattern="[a-zA-Z0-99áéíóúÁÉÍÓÚñÑ()# ]{1,50}" class="form-control" name="usuario_nombre_contacto" id="usuario_nombre_contacto" maxlength="50">
									</div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="usuario_email" class="bmd-label-floating">correo Electrónico</label>
                                            <input type="email" class="form-control" name="usuario_email" id="usuario_email" maxlength="70">
                                        </div>
								</div>
							</div>
						</div>
					</fieldset>
					<br><br><br>
                    <fieldset>
						<legend><i class="fas fa-medal"></i> &nbsp; Información materiales</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="usuario_categoria_materiales" class="bmd-label-floating">categorias materiales</label>
										<select id="material-categories" name="material_categories[]" multiple required>
                                            <option value="hilos">Hilos</option>
                                            <option value="tela">Telas</option>
                                            <option value="cremallera">Cremallera</option>
                                            <option value="cordonea">Cordones</option>
                                            <option value="otros">Otros</option>
                                        </select>
									</div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="usuario_descripcion_materiales" class="bmd-label-floating">descripcion materiales</label>
                                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,200}" class="form-control" name="usuario_descripcion_materiales" id="usuario_descripcion_materiales" maxlength="200">
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="usuario_nota_adicional" class="bmd-label-floating">nota adicional</label>
                                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,200}" class="form-control" name="usuario_nota_adicional" id="usuario_nota_adicional" maxlength="200">
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
			</div>
        
			

		</section>
	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>

	
</body>
</html>
           

