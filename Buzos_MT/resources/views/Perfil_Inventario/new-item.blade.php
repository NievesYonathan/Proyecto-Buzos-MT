<x-app-layout>
    <!--CONTENT-->
    <div class="container-fluid mt-5">
        <form action="{{ route('reg-nuevo-producto')}}" class="form-neon" autocomplete="off"
            method="POST">
            @csrf
            <fieldset>
                <legend><i class="far fa-plus-square"></i> &nbsp; Información del item</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nombre" class="bmd-label-floating">Nombre</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,140}"
                                    class="form-control" name="nombre" id="nombre" maxlength="140">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="descripcion" class="bmd-label-floating">Descripción</label>
                                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,255}"
                                    class="form-control" name="descripcion" id="descripcion"
                                    maxlength="255">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="cantidad" class="bmd-label-floating">Cantidad</label>
                                <input type="number" pattern="[0-9]{1,9}" class="form-control"
                                    name="cantidad" id="cantidad" maxlength="9">
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="unidad_medida" class="bmd-label-floating">Unidad de Medida</label>
                                <select class="form-control" name="unidad_medida" id="unidad_medida">
                                    <option value="" selected="" disabled="">Seleccione una opción</option>
                                    <option value="Metros">Metros (M)</option>
                                    <option value="Centimetros">Centímetros (Cm)</option>
                                    <option value="Milimetros">Milímetros (Mm)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="estado" class="bmd-label-floating">Estado</label>
                                <select class="form-control" name="estado" id="estado">
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
                                <label for="fecha_compra" class="bmd-label-floating">Fecha de Compra</label>
                                <input type="date" class="form-control" name="fecha_compra"
                                    id="fecha_compra">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="proveedor_id" class="bmd-label-floating">Proveedor</label>
                                <select class="form-control" name="proveedor_id" id="proveedor_id">
                                    @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->num_doc }}">
                                        {{ $proveedor->usu_nombres }} {{ $proveedor->usu_apellidos }}
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