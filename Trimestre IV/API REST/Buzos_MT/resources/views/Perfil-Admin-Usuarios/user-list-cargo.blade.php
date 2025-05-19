<x-app-layout>
	<div class="full-box page-header">
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
					@foreach($usuarios as $usuario)
					<tr class="table-light text-center">
					<td>{{ optional($usuario->tipo_documento)->tip_doc_descripcion }}</td>
						<td>{{ $usuario->num_doc }}</td>
						<td>{{ $usuario->usu_nombres }}</td>
						<td>
							@foreach($usuario->cargos as $cargo)
							{{ $cargo->car_nombre }}
							@endforeach
						</td>
						<td>
							<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal{{ $usuario->num_doc }}">
								<i class="fa-solid fa-user-plus"></i>
							</button>
						</td>
					</tr>

					<!-- Modal para agregar Cargos -->
					<div class="modal fade" id="addModal{{ $usuario->num_doc }}" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<form method="POST" action="{{ route('cargosUsuarios.store') }}">
									@csrf
									<div class="modal-header">
										<h5 class="modal-title" id="addModalLabel">Agregar Cargos / {{ $usuario->num_doc }}</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										<input type="hidden" name="numDoc" value="{{ $usuario->num_doc }}">
									</div>
									<div class="modal-body">
										<div class="form-check form-switch">
											@foreach($cargos as $cargo)
											<input class="form-check-input" type="checkbox" name="idCargo[]" value="{{ $cargo['id_cargos'] }}" id="checkbox{{ $cargo['id_cargos'] }}">
											<label class="form-check-label" for="checkbox{{ $cargo['id_cargos'] }}">{{ $cargo['car_nombre'] }}</label><br>
											@endforeach
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Guardar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					@endforeach
				</tbody>
			</table>
		</div>

		<!-- Paginación -->
		<nav aria-label="Page navigation example">
			<ul class="pagination justify-content-center">
				<!-- Paginación personalizada (si es necesario) -->
				{{ $usuarios->links() }}
			</ul>
		</nav>
	</div>
</x-app-layout>