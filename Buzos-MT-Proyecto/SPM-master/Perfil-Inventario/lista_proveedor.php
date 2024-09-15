<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
	<?php 
	include '../Config/variable_global.php';
	include '../Componentes/Head/head.php';
	?>

<body>

		<!-- Nav lateral -->
		<?php include '../Componentes/Sidebar/sidebar.php'; ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<!-- Navbar -->
			<?php include '../Componentes/Navbar/navbar.php'; ?>

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PROVEEDORES
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="CPP.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PROVEEDOR</a>
					</li>
					<li>
						<a class="active" href="LPP.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA
							DE PROVEEDORES</a>
					</li>
					<li>
						<a href="PPS.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PROVEEDOR</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
				<table class="table table-dark table-sm">
    <thead>
        <tr class="text-center roboto-medium">
            <th>Numero de documento</th>
            <th>Tipo de documento</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Fecha de contratación</th>
            <th>Estado</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
    <?php

        include_once "../Controlador/ControladorUsuario.php";

        $controladorUsuario = new ControladorProveedor();
        $res = $controladorUsuario->mostrarProveedor();

        
        while ($fila = $res->fetch_assoc()) {
    ?>
            <tr class="text-center">
                <td><?= $fila['num_doc'] ?></td>
                <td><?= $fila['t_doc'] ?></td>
                <td><?= $fila['usu_nombres'] ?></td>
                <td><?= $fila['usu_apellidos'] ?></td>
                <td><?= $fila['usu_direccion'] ?></td>
                <td><?= $fila['usu_telefono'] ?></td>
                <td><?= $fila['usu_email'] ?></td>
                <td><?= $fila['usu_fecha_contratacion'] ?></td>
                <td><?= $fila['usu_estado'] ?></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal<?= $fila['num_doc'] ?>">
                        <i class="fa-solid fa-user-pen"></i>
                    </button>
                </td>
                <td>
                    <form action="">
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $fila['num_doc'] ?>">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
    <?php
        }
    ?>
    </tbody>
</table>

				</div>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item disabled">
							<a class="page-link" href="#" tabindex="-1">Previous</a>
						</li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="#">Next</a>
						</li>
					</ul>
				</nav>
			</div>

		</section>
	</main>

	<!--===Include JavaScript files======-->
	<?php include '../Componentes/Script/script.php'; ?>
</body>

</html>
