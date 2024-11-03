<?php
session_start();
include '../Modelo/ModeloTarea.php';
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
					<i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR TAREAS
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a class="active" href="nueva-tarea.php"><i class="fas fa-plus fa-fw"></i> &nbsp; TAREAS</a>
					</li>
					<li>
						<a href="lista-tareas.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE TAREAS</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
			<form action="../Controlador/ControladorTarea.php" method="POST" class="form-neon" autocomplete="off">
    <fieldset>
        <legend><i class="fas fa-user-lock"></i> &nbsp; Registrar nueva tarea</legend>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="tarea_sistema" class="bmd-label-floating">Nombre de la tarea</label>
                        <input type="text" class="form-control" name="tarea_sistema" id="tarea_sistema" required>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="descripcion" class="bmd-label-floating">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="estado" class="bmd-label-floating">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="" disabled selected>Seleccione un estado</option>
                            <!-- Agrega aquí las opciones para los estados -->
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <input type="hidden" name="Accion" value="Guardar">
    <p class="text-center" style="margin-top: 40px;">
        <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
        &nbsp; &nbsp;
        <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
    </p>
</form>



				<br>

				<div class="form-neon mt-20">
					<legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de tareas</legend>
					<!-- Elimina el punto de la lista -->
					<style>
						ul {
							list-style-type: none;
						}
					</style>
					<ul>
						<?php
						include_once '../Controlador/ControladorTarea.php';
						$ModeloTarea = new ControladorTarea();
						$res = $ModeloTarea->getTarea();

						while ($fila = mysqli_fetch_assoc($res)) {
							echo '<li><i class="fas fa-check-circle"></i> ' . $fila['tar_nombre'] . ' 
									<button data-bs-toggle="modal" data-bs-target="#updateModal' . $fila['id_tarea'] . '">
										<i class="fa-regular fa-pen-to-square"></i>
									</button>
								   </li>';
						?>
							<!-- Modal para editar usuarios -->
<div class="modal fade" id="updateModal<?= $fila['id_tarea'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../Controlador/ControladorTarea.php" method="post">
                    <input type="hidden" name="id" value="<?= $fila['id_tarea'] ?>">
                    <fieldset>
                        <legend><i class="far fa-address-card"></i> &nbsp; Editar tarea</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Campo para nombre -->
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="usuario_nombre" class="bmd-label-floating">Nombre</label>
                                        <input type="text" class="form-control" name="tar_nombre" id="usuario_nombre" value="<?= $fila['tar_nombre'] ?>" maxlength="60">
                                    </div>
                                </div>
                                
                                <!-- Campo para descripción -->
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="bmd-label-floating">Descripción</label>
                                        <textarea class="form-control" name="tar_descripcion" id="descripcion" rows="3"><?= $fila['tar_descripcion'] ?></textarea>
                                    </div>
                                </div>

                                <!-- Campo para estado -->
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="estado" class="bmd-label-floating">Estado</label>
                                        <select class="form-control" name="tar_estado" id="estado">
                                            <option value="1" <?= $fila['tar_estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                                            <option value="2" <?= $fila['tar_estado'] == 2 ? 'selected' : '' ?>>Inactivo</option>
                                            <!-- Agrega más opciones según los estados disponibles en tu base de datos -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" name="Accion" value="Actualizar">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

						<?php
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