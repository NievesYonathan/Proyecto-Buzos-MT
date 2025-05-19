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
	include '../Componentes/Head/head.php' ;?>
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
                    <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR ITEM
                </h3>
            </div>
            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a href="item-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR ITEM</a>
                    </li>
                    <li>
                        <a href="item-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE ITEMS</a>
                    </li>
                    <li>
                        <a href="item-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR ITEM</a>
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
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="item_codigo" class="bmd-label-floating">Códido</label>
										<input type="text" pattern="[a-zA-Z0-9-]{1,45}" class="form-control" name="matId" id="item_codigo" maxlength="45" value="<?=$_POST['matId']?>" readonly>
									</div>
								</div>
								
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="item_nombre" class="bmd-label-floating">Nombre</label>
										<input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}" class="form-control" name="matNombre" id="item_nombre" maxlength="140" value="<?=$_POST['matNombre']?>" readonly>
									</div>
								</div>
								<div class="col-12 col-md-4">
									<div class="form-group">
										<label for="item_stock" class="bmd-label-floating">Stock</label>
										<input type="num" pattern="[0-9]{1,9}" class="form-control" name="matCantidad" id="item_stock" maxlength="9"value="<?=$_POST['matCantidad']?>">
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="item_estado" class="bmd-label-floating">Estado</label>
										<select class="form-control" name="matEstado" id="item_estado" required>
    <option value="" disabled selected>Seleccione una opción</option>
    
    <?php
    // Obtener el estado actual de la materia prima
    $estadoMatPri = $contObj->consultarEstadoMatPri($_POST['matId']); 
    $estadoActual = mysqli_fetch_object($estadoMatPri);
    
    // Mostrar el estado actual como una opción seleccionada, pero deshabilitada
    echo '<option value="'.$estadoActual->id.'" selected>'.$estadoActual->estado.'</option>';

    // Obtener el resto de los estados, excluyendo el estado actual
    $estados = $contObj->consultarEstados();
    while ($estado = mysqli_fetch_object($estados)) {
        // Si el estado no es el actual, lo mostramos como opción seleccionable
        if ($estado->id_estados != $estadoActual->id) {
            echo '<option value="'.$estado->id_estados.'">'.$estado->nombre_estado.'</option>';
        }
    }
    ?>
</select>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-group">
										<label for="item_detalle" class="bmd-label-floating">Detalle</label>
										<input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9()- ]{1,190}" class="form-control" name="matDescripcion" id="item_detalle" maxlength="190" value="<?=$_POST['matDescripcion']?>" required>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<br><br><br>
					<p class="text-center" style="margin-top: 40px;">
						<button type="submit" class="btn btn-raised btn-success btn-sm" name="accion" value="actualizar"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
					</p>
				</form>
			</div>
        </section>




    </main>
    
    	
	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php' ?>
</body>
</html>