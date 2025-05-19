<x-app-layout>
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; INFORMES Y REPORTES
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="{{ route('informe-RRHH') }}">
                <i class="fas fa-search fa-fw"></i> &nbsp; INFORME RECURSOS HUMANOS
            </a>
        </li>
    </ul>
</div>

<div class="container-fluid tile-container">
    <div class="table-responsive">
        <table class="table table-dark table-sm">
            <thead>
                <tr class="text-center roboto-medium">
                    <th>EMPLEADOS ACTIVOS</th>
                    <th>EMPLEADOS CON CARGO</th>
                    <th>USUARIOS INACTIVOS</th>
                </tr>
            </thead>
            <tbody>
            <tr class="table-light text-center">
                    <td>{{ $activos }}</td>
                    <td>{{ $conCargo }}</td>
                    <td>{{ $inactivos }}</td>
                </tr>
                <tr class="text-center roboto-medium">
                    <td><button class="clickable-col btn btn-info btn-sm" data-col="activos">Ver Activos</button></td>
                    <td><button class="clickable-col btn btn-info btn-sm" data-col="cargos">Ver Con Cargo</button></td>
                    <td><button class="clickable-col btn btn-info btn-sm" data-col="inactivos">Ver Inactivos</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModal">Detalles de Usuarios</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                        <tr class="table-light text-center">
                                <th>Tipo Doc</th>
                                <th>Documento</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Cargo</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <!-- Datos llenados mediante AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Tu script -->
<script src="{{ asset('js/informes.js') }}"></script>


</x-app-layout>