<x-app-layout>
            <div class="container my-5">
                <h3 class="text-left">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO.
                </h3>
            </div>

            <!-- Inicio Alerta PHP -->
            <?php if (isset($_SESSION['alerta'])): ?>
                <div class="alert alert-info" role="alert" style="position: fixed; top: 20px; left: 20px; padding: 15px; border: 1px solid #12464c; border-radius: 8px; background-color: #12464c; color: white; z-index: 9999;">
                    <?php echo $_SESSION['alerta']; ?>
                </div>
                <script>
                    setTimeout(function() {
                        document.querySelector('.alert').style.display = 'none';
                    }, 4000);
                </script>
                <?php unset($_SESSION['alerta']); ?>
            <?php endif; ?>
            <!-- Fin Alerta PHP -->

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li><a href="{{ route('user-new') }}"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a></li>
                    <li><a href="{{ route('user-list') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a></li>
                    <li><a class="active" href="{{ route('user-list') }}"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a></li>
                </ul>
            </div>

            <!-- Content -->
            <div class="container-fluid">
                <form class="form-neon" method="GET" action="user-search.php">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="inputSearch" class="bmd-label-floating">¿Qué usuario estás buscando?</label>
                                    <input type="text" class="form-control" name="search" id="inputSearch" maxlength="30" value="<?php echo htmlspecialchars($search); ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-center" style="margin-top: 40px;">
                                    <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-dark table-sm">
                        <thead>
                            <tr class="text-center roboto-medium">
                            <th>TIPO DE DOCUMENTO</th>
                                    <th>NUMERO DE DOCUMENTO</th>
                                    <th>NOMBRE</th>
                                    <th>APELLIDO</th>
                                    <th>FECHA DE NACIMIENTO</th>
                                    <th>SEXO</th>
                                    <th>TELÉFONO</th>
                                    <th>EMAIL</th>
                                    <th>DIRECCION</th>
                                    <th>FECHA DE CONTRATACION</th>
                                    <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($resultado && $resultado instanceof mysqli_result && $resultado->num_rows > 0) { ?>
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <tr>
        <td class="text-center"><?php echo htmlspecialchars($row['t_doc']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['num_doc']); ?></td>
            <td><?php echo htmlspecialchars($row['usu_nombres']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['usu_apellidos']); ?></td>
            <td><?php echo htmlspecialchars($row['usu_fecha_nacimiento']); ?></td>
            <td><?php echo htmlspecialchars($row['usu_sexo']); ?></td>
            <td><?php echo htmlspecialchars($row['usu_telefono']); ?></td>
            <td><?php echo htmlspecialchars($row['usu_email']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['usu_direccion']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['usu_fecha_contratacion']); ?></td>
            <td><?php echo htmlspecialchars($row['estado_nombre']); ?></td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td colspan="11" class="text-center">No se encontraron resultados.</td>
    </tr>
<?php } ?>

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
