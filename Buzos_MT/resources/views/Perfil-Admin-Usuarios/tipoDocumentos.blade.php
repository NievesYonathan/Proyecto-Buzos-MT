<x-app-layout>
	<div class="full-box page-header">
		<h3 class="text-left">
			<i class="fas fa-plus fa-fw"></i> &nbsp; GESTIONAR TIPOS DE DOCUMENTOS
		</h3>
	</div>

	<!-- Content -->
	<div class="container-fluid">
		<form action="{{ route('tipoDocumentos.store') }}" method="POST" class="form-neon" autocomplete="off">
			@csrf
			<fieldset>
				<legend><i class="fas fa-user-lock"></i> &nbsp; Registrar Tipos de Documentos</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-12">
							<div class="form-group">
								<label for="nombreDoc" class="bmd-label-floating">Ingrese el tipo de documento</label>
								<input type="text" class="form-control" name="tip_doc_descripcion" id="nombreDoc">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<p class="text-center" style="margin-top: 40px;">
				<button type="reset" class="btn btn-raised btn-secondary btn-sm">
					<i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
				</button>
				&nbsp; &nbsp;
				<button type="submit" class="btn btn-raised btn-info btn-sm">
					<i class="far fa-save"></i> &nbsp; GUARDAR
				</button>
			</p>
		</form>

		<br>

		<div class="form-neon mt-20">
			<legend><i class="fa-regular fa-address-book"></i> &nbsp; Lista de Tipos de Documentos</legend>
			<!-- Estilo para eliminar los puntos de la lista -->
			<style>
				ul {
					list-style-type: none;
				}
			</style>
			<ul>
				@foreach ($tipoDocumentos as $tipo)
				<li class="mb-2">
					<i class="fas fa-check-circle"></i> {{ $tipo['tip_doc_descripcion'] }}
					<button data-bs-toggle="modal" data-bs-target="#updateModal{{ $tipo['id_tipo_documento'] }}">
						<i class="fa-regular fa-pen-to-square"></i>
					</button>
				</li>

				<!-- Modal para editar tipos de documento -->
				<div class="modal fade" id="updateModal{{ $tipo['id_tipo_documento'] }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<form action="{{ route('tipoDocumentos.update', $tipo['id_tipo_documento']) }}" method="POST">
									@csrf
									@method('PUT')
									<fieldset>
										<legend><i class="far fa-address-card"></i> &nbsp; Editar Tipo de Documento</legend>
										<div class="container-fluid">
											<div class="row">
												<div class="col-12 col-md-12">
													<div class="form-group">
														<label for="nombreDocEdit" class="bmd-label-floating">Nombre</label>
														<input type="text" class="form-control" name="tip_doc_descripcion" id="tip_doc_descripcion" value="{{ $tipo['tip_doc_descripcion'] }}" maxlength="60">
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<div class="modal-footer">
										<button class="btn btn-success" type="submit">Actualizar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</ul>
		</div>
	</div>
</x-app-layout>
