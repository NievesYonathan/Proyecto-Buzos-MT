<x-app-layout>
			<div class="container my-5">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
				</h3>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="{{ route('cargos') }}"><i class="fas fa-plus fa-fw"></i> &nbsp; CARGOS</a>
					</li>
					<li>
						<a class="active" href="{{ route('user-list-cargo') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								<th>Tipo Documento</th>
								<th>Numero</th>
								<th>Nombre</th>
								<th>Cargo</th>
								<th>Añadir Cargo</th>
							</tr>
						</thead>
						<tbody>
							
								<tr class="text-center">
									<td class="my-auto"><?= $filaU['tip_doc_descripcion'] ?></td>
									<td><?= $filaU['num_doc'] ?></td>
									<td><?= $filaU['usu_nombres'] ?></td>
									<td><?= $filaU['Cargos'] ?></td>
								
									<td><button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal<?= $filaU['num_doc'] ?>"><i class="fa-solid fa-user-plus"></i></button></td>
								</tr>
								<!-- Modal para agregar Cargos -->
								<div class="modal fade" id="addModal<?= $filaU['num_doc'] ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<form method="POST" action="../Controlador/ControladorCarUsu.php">
												<div class="modal-header">
													<h5 class="modal-title" id="addModalLabel">Agregar Cargos / <?= $filaU['num_doc'] ?></h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													<input type="hidden" value="<?= $filaU['num_doc'] ?>" name="numDoc">
												</div>
												<div class="modal-body">
													<div class="form-check form-switch">
													</div>
												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary">Guardar</button>
												</div>
											</form>
										</div>
									</div>
								</div>
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
</x-app-layout>