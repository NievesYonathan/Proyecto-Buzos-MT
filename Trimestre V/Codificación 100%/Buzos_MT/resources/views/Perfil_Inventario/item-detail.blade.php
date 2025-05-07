<x-app-layout>
            <!--CONTENT-->
           <div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
							<tr class="text-center roboto-medium">
								<th>#</th>
								<th>NOMBRE</th>
								<th>STOCK</th>
								<th>DESCRIPCIÒN</th>
								<th>UNIDAD DE MEDIDA</th>
								<th>ESTADO</th>
							</tr>
						</thead>
						<tbody>
							<tr class="text-center table-light details">
								<td><?=$materiaPrima->id_materia_prima?></td>
								<td><?=$materiaPrima->mat_pri_nombre?></td>
								<td><?=$materiaPrima->mat_pri_cantidad?></td>
								<td><?=$materiaPrima->mat_pri_descripcion?></td>
                                <td><?=$materiaPrima->mat_pri_unidad_medida?></td>
								<td>{{$materiaPrima->estado->nombre_estado}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </section>
    </main>
</x-app-layout>