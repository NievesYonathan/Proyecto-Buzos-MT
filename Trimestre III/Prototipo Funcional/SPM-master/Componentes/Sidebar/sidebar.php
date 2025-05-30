<section class="full-box nav-lateral">

	<div class="full-box nav-lateral-content">
		<a href="../Dashboard/home.php" class="btn btn-secondary" id="btn-reversa">
			<i class="fa fa-arrow-left"></i>
		</a>

		<?php
		include '../Config/variable_global.php';
		$name = $_SESSION['user_nombre'];
		$perfil = $_SESSION['user_cargo'];
		?>
		<figure class="full-box nav-lateral-avatar">
			<i class="far fa-times-circle show-nav-lateral"></i>
			<img src="../assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
			<figcaption class="roboto-medium text-name">
				<?= $name ?> <br><small class="roboto-condensed-light"><?= $perfil ?></small>
			</figcaption>
		</figure>

		<div class="full-box nav-lateral-bar"></div> <!-- Barra roja de división -->

		<nav class="full-box nav-lateral-menu">
			<ul>
				<li>
					<a href="../Dashboard/home.php"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Dashboard</a>
				</li>

				<!-- <li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-users fa-fw"></i> &nbsp; Clientes <i class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="client-new.html"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar Cliente</a>
						</li>
						<li>
							<a href="client-list.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de clientes</a>
						</li>
						<li>
							<a href="client-search.html"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar cliente</a>
						</li>
					</ul>
				</li> -->

				<?php
				//Enlace solo visible para Admin de Inventario
				if ($perfil == 'Jefe Inventario'): ?>
					<li>
						<a href="#" class="nav-btn-submenu"><i class="fas fa-pallet fa-fw"></i> &nbsp; Materia Prima <i class="fas fa-chevron-down"></i></a>
						<ul>
							<li>
								<a href="../Perfil-Inventario/item-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; Agregar item</a>
							</li>
							<li>
								<a href="../Perfil-Inventario/item-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de items</a>
							</li>
							<li>
								<a href="../Perfil-Inventario/item-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar item</a>
							</li>
							<li>
								<a href="../Perfil-Inventario/item-detail.php"><i class="fa-solid fa-info-circle"></i> &nbsp; Detalles item</a>
							</li>
							<li>
								<a href="../Perfil-Inventario/item-history.php"><i class="fa-solid fa-clock-rotate-left"></i> &nbsp; Historial</a>
							</li>
							<li>
								<a href="../Perfil-Inventario/item-update.php"><i class="fa-solid fa-pen-to-square"></i> &nbsp; Actualizar</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>

				<!-- <li>
					<a href="#" class="nav-btn-submenu"><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp; Préstamos <i class="fas fa-chevron-down"></i></a>
					<ul>
						<li>
							<a href="reservation-new.html"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo préstamo</a>
						</li>
						<li>
							<a href="reservation-list.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de préstamos</a>
						</li>
						<li>
							<a href="reservation-search.html"><i class="fas fa-search-dollar fa-fw"></i> &nbsp; Buscar préstamos</a>
						</li>
						<li>
							<a href="reservation-pending.html"><i class="fas fa-hand-holding-usd fa-fw"></i> &nbsp; Préstamos pendientes</a>
						</li>
					</ul>
				</li> -->

				<?php
				//Enlace solo visible para Admin de Usuario
				if ($perfil == 'Administrador Usuario'): ?>
					<li>
						<a href="#" class="nav-btn-submenu"><i class="fa-solid fa-user fa-fw"></i> &nbsp; Usuarios <i class="fas fa-chevron-down"></i></a>
						<ul>
							<li>
								<a href="../Perfil-Admin-Usuarios/user-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; Nuevo usuario</a>
							</li>
							<li>
								<a href="../Perfil-Admin-Usuarios/user-list.php"><i class="fa-solid fa-user-tie"></i> &nbsp; Empleados</a>
							</li>
							<li>
								<a href="../Perfil-Inventario/lista_proveedor.php"><i class="fa-solid fa-truck"></i> &nbsp; Proveedores</a>
							</li>
							<li>
								<a href="../Perfil-Admin-Usuarios/user-search.php"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar usuario</a>
							</li>
							<li>
								<a href="../Perfil-Admin-Usuarios/tipoDocumentos.php"><i class="fa-brands fa-dochub"></i> &nbsp; Tipos de Documentos</a>
							</li>
							<li>
								<a href="../Perfil-Admin-Usuarios/vistaEstados.php"><i class="fa-solid fa-e"></i> &nbsp; Estados</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>

				<?php
				//Enlace solo visible para Admin de Usuario
				if ($perfil == 'Administrador Usuario'): ?>
					<li>
						<a href="../Perfil-Admin-Usuarios/cargos.php"><i class="fa-solid fa-address-book"></i> &nbsp; Cargos </a>
					</li>
				<?php endif; ?>


				<?php
				//Enlace solo visible para Jefe de Producción
				if ($perfil == 'Jefe Producción'): ?>
					<li>
						<a href="#" class="nav-btn-submenu"><i class="fa-solid fa-industry"></i> &nbsp; Producción <i class="fas fa-chevron-down"></i></a>
						<ul>
							<li>
								<a href="../Perfil-Produccion/vista-produccion.php"><i class="fa-solid fa-industry"></i> &nbsp; Gestion de Producción</a>
							</li>
							<li>
								<a href="../Perfil-Produccion/vista-pro-fabricados.php" style="font-size: 15px"><i class="fa-solid fa-shirt"></i> &nbsp; Gestion Productos Fabricados</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="../Perfil-Operarios/nueva-tarea.php"><i class="fa-solid fa-calendar-days"></i> &nbsp; Tareas </a>
					</li>
				<?php endif; ?>

				<?php
				//Enlace solo visible para Jefe de Producción | Administrador de Usuarios | Administrador de Inventario
				if ($perfil == 'Jefe Producción' || $perfil == 'Administrador Usuario' || $perfil == 'Jefe Inventario'): ?>
					<li>
						<a href="#" class="nav-btn-submenu"><i class="fa-solid fa-file-circle-plus"></i> &nbsp; Informes <i class="fas fa-chevron-down"></i></a>
						<ul>
							<li>
								<a href="../Informes/informes.php"><i class="fa-solid fa-boxes-stacked"></i> &nbsp; Inventario</a>
							</li>
							<li>
								<a href="../Informes/info-produccion.php"><i class="fa-solid fa-industry"></i> &nbsp; Producción</a>
							</li>
							<?php
							if ($perfil == 'Administrador Usuario') { ?>
								<li>
									<a href="../Informes/info-Rec.Humanos.php"><i class="fa-solid fa-users"></i> &nbsp; RR.HH</a>
								</li>
							<?php
							}
							?>
							<li>
								<a href="../Informes/reporte_inventario.php"><i class="fa-solid fa-users"></i> &nbsp; Reporte Inventario</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>

				<?php
				//Enlace solo visible para Operarios
				if ($perfil == 'Operario'): ?>
					<li><a href="../Perfil-Operarios/vista-tar-asignadas.php"><i class="fa-brands fa-stack-exchange"></i> &nbsp; Mis Tareas</a></li>
				<?php endif; ?>
				
				<li>
					<a href="../Perfil-Admin-Usuarios/user-update.php"><i class="fa-solid fa-gear"></i> &nbsp; Configuración</a>
				</li>

				
			</ul>
		</nav>
	</div>
</section>