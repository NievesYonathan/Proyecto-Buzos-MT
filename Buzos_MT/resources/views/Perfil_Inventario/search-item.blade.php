<x-app-layout>
    <div class="container-fluid">
        <form class="form-neon" action="{{ route('resultados-producto') }}" method="post">
            @csrf
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="inputSearch" class="bmd-label-floating">¿Qué item estás buscando?</label>
                        <input type="text" class="form-control" name="busqueda" id="inputSearch" maxlength="30" required>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-info">
                            <i class="fas fa-search"></i> &nbsp; BUSCAR
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
