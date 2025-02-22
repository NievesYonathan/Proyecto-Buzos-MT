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
			<i class="fas fa-plus fa-fw"></i> &nbsp; Registro de pedidos y pagos
		</h3>
	</div>

	<div class="container-fluid">
		<ul class="full-box list-unstyled page-nav-tabs">
			<li>
				<a class="active" href="RP.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PEDIDO</a>
			</li>
			<li>
				<a href="LP.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PEDIDOS</a>
			</li>
			<li>
				<a href="PS.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PEDIDO</a>
			</li>
		</ul>
	</div>

	<!-- Content -->
	<div class="container-fluid">
		<form action="" class="form-neon" autocomplete="off">
			<fieldset>
				<legend><i class="far fa-address-card"></i> &nbsp; Información del pedido</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_ID_pedido" class="bmd-label-floating">ID pedido</label>
								<input type="text" pattern="[0-9-]{1,20}" class="form-control" name="usuario_ID_pedido"
									id="usuario_ID_pedido" maxlength="20">
							</div>
						</div>

						<div class="col-12 col-md-4">
								<label for="usuario_fecha_pedido" class="bmd-label-floating"><label
										for="usuario_fecha_pedido" class="bmd-label-floating">Fecha del
										pedido</label>
									<input type="date" class="form-control" name="usuario_fecha_pedido"
										id="usuario_fecha_pedido">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_monto_pedido" class="bmd-label-floating">monto del
									pedido</label>
								<input type="text" pattern="[0-9()+]{1,20}" class="form-control"
									name="usuario_monto_pedido" id="usuario_monto_pedido" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_estado_pedido" class="bmd-label-floating">estado del
									pedido</label>
								<select id="usuario_estado_pedido" name="usuario_estado_pedido" required>
									<option value="pendiente">Pendiente</option>
									<option value="en_proceso">En Proceso</option>
									<option value="completado">Completado</option>
									<option value="cancelado">Cancelado</option>
								</select>
							</div>
						</div>
			</fieldset>
			<br><br><br>
			<fieldset>
				<legend><i class="fas fa-user-lock"></i> &nbsp; Información del pago</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_ID_pago" class="bmd-label-floating">ID del pago</label>
								<input type="text" pattern="[0-9()+]{1,20}" class="form-control" name="usuario_ID_pago"
									id="usuario_ID_pago" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-6">
								<label for="usuario_fecha_pago" class="bmd-label-floating"><label
										for="usuario_fecha_pago" class="bmd-label-floating">Fecha del
										pedido</label>
									<input type="date" class="form-control" name="usuario_fecha_pago"
										id="usuario_fecha_pago">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_monto_pago" class="bmd-label-floating">monto del
									pago</label>
								<input type="text" pattern="[0-9()+]{1,20}" class="form-control"
									name="usuario_monto_pago" id="usuario_monto_pago" maxlength="10">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_estado_pago" class="bmd-label-floating">estado del
									pago</label>
								<select id="usuario_estado_pago" name="usuario_estado_pago" required>
									<option value="pendiente">Pendiente</option>
									<option value="en_proceso">En Proceso</option>
									<option value="completado">Completado</option>
									<option value="cancelado">Cancelado</option>
								</select>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="performance-rating">Calificación de Desempeño:</label>
									<select id="performance-rating" name="performance_rating" required>
										<option value="excelente">Excelente</option>
										<option value="bueno">Bueno</option>
										<option value="regular">Regular</option>
										<option value="malo">Malo</option>
									</select>
								</div>
							</div>
						</div>
					</div>
			</fieldset>
			<br><br><br>
			<fieldset>
				<legend><i class="fas fa-medal"></i> &nbsp; notas adicionales</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="usuario_nota_adicional" class="bmd-label-floating">Nota
									adicional</label>
								<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,200}" class="form-control"
									name="usuario_nota_adicional" id="usuario_nota_adicional" maxlength="200">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
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