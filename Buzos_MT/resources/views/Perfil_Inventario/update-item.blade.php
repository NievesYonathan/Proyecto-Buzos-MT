<x-app-layout> 
        <!--CONTENT-->
        <div class="container-fluid mt-5">
        <form action="{{ route('update-producto', $materiaPrima->id_materia_prima)}}" class="form-neon" autocomplete="off"
            method="post">
            <fieldset>
                <legend><i class="far fa-plus-square"></i> &nbsp; Información del item</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mat_pri_nombre" class="bmd-label-floating">Nombre</label>
                                <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}"
                                    class="form-control" name="mat_pri_nombre" id="matNombre" maxlength="140">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="mat_pri_descripcion" class="bmd-label-floating">Descripción</label>
                                <input type="text" pattern="[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,255}"
                                    class="form-control" name="mat_pri_descripcion" id="matDescripcion"
                                    maxlength="255">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="mat_pri_cantidad" class="bmd-label-floating">Cantidad</label>
                                <input type="number" pattern="[0-9]{1,9}" class="form-control"
                                    name="mat_pri_cantidad" id="matCantidad" maxlength="9">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="mat_pri_unidad_medida" class="bmd-label-floating">Unidad de Medida</label>
                                <select class="form-control" name="mat_pri_unidad_medida" id="matUnidad">
                                    <option value="" selected="" disabled="">Seleccione una opción</option>
                                    <option value="Metros">Metros (M)</option>
                                    <option value="Centrimetros">Centimetros (Cm)</option>
                                    <option value="Milimetros">Milimetros (Mm)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="mat_pri_estado" class="bmd-label-floating">Estado</label>
                                <select class="form-control" name="mat_pri_estado" id="matEstado">
                                    @foreach ($estados as $estado)
                                        @if ($estado->nombre_estado === 'Activo' || $estado->nombre_estado === 'Inactivo')
                                        <option value="{{ $estado->id_estados }}">
                                            {{ $estado->nombre_estado }}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="fecha_compra_mp" class="bmd-label-floating">Fecha de Compra</label>
                                <input type="date" class="form-control" name="fecha_compra_mp"
                                    id="matFechaCompra">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="proveedores_id_proveedores"" class="bmd-label-floating">Proveedor</label>
                                <select class="form-control" name="proveedores_id_proveedores"" id="matProveedor">
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->num_doc }}">
                                            {{ $proveedor->usu_nombres }}
                                            {{ $proveedor->usu_apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i
                        class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm" name="accion" value="agregar"><i
                        class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
        </form>
    </div>

</x-app-layout>