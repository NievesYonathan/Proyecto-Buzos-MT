<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: ../login-registro/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">
	<?php 
	include_once '../Controlador/ControladorMateriasP.php';
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
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM
                </h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque laudantium necessitatibus eius iure adipisci modi distinctio. Earum repellat iste et aut, ullam, animi similique sed soluta tempore cum quis corporis!
                </p>
            </div>
            <div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="item-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
					</li>
					<li>
						<a href="item-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
					</li>
				</ul>
			</div>
			
			<!--CONTENT-->
			<div class="container-fluid">
				<form action="../Controlador/ControladorMateriasP.php" class="form-neon" autocomplete="off" method="post">
					<fieldset>
						<legend><i class="far fa-plus-square"></i> &nbsp; Información del item</legend>
						<div class="container-fluid">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="matNombre" class="bmd-label-floating">Nombre</label>
										<input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="matNombre" id="matNombre" maxlength="140">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="matDescripcion" class="bmd-label-floating">Descripción</label>
										<input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,255}" class="form-control" name="matDescripcion" id="matDescripcion" maxlength="255">
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="matCantidad" class="bmd-label-floating">Cantidad</label>
										<input type="number" pattern="[0-9]{1,9}" class="form-control" name="matCantidad" id="matCantidad" maxlength="9">
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="matUnidad" class="bmd-label-floating">Unidad de Medida</label>
										<select class="form-control" name="matUnidad" id="matUnidad">
											<option value="" selected="" disabled="">Seleccione una opción</option>
													<option value="Metros">Metros  (M)</option>
													<option value="Centrimetros">Centimetros  (Cm)</option>
													<option value="Milimetros">Milimetros  (Mm)</option>
										</select>
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="matEstado" class="bmd-label-floating">Estado</label>
										<select class="form-control" name="matEstado" id="matEstado">
											<option value="" selected="" disabled="">Seleccione una opción</option>
											<?php
												
												$result = $contObj->consultarEstados();
												while ($estado = mysqli_fetch_object($result)) {
													echo '<option value="'.$estado->idEstado.'">'.$estado->nombreEstado.'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="matFechaCompra" class="bmd-label-floating">Fecha de Compra</label>
										<input type="date" class="form-control" name="matFechaCompra" id="matFechaCompra">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="matProveedor" class="bmd-label-floating">Proveedor</label>
										<input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="matProveedor" id="matProveedor" maxlength="140">
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<br><br><br>
					<p class="text-center" style="margin-top: 40px;">
						<button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
						&nbsp; &nbsp;
						<button type="submit" class="btn btn-raised btn-info btn-sm" name="accion" value="agregar"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
					</p>
				</form>
			</div>
		</section>




	</main>
	
	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>
</html>