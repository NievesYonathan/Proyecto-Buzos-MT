<x-app-layout>
    <div class="container-fluid">
        <div class="table-overflow-x">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>#</th>
                        <th>NOMBRE</th>
                        <th>STOCK</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody id="materiaPrimaTable">
                    <!-- Los datos se insertarán dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("http://localhost:8000/api/materia-prima")
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.getElementById("materiaPrimaTable");
                    tableBody.innerHTML = "";

                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No hay materias primas registradas.</td></tr>`;
                    } else {
                        data.forEach(item => {
                            let row = document.createElement("tr");
                            row.classList.add("text-center", "table-light");
                            row.style.cursor = "pointer";

                            // Hace que la fila abra el modal excepto si se toca un botón
                            row.addEventListener("click", function (event) {
                                if (!event.target.closest("button") && !event.target.closest("a")) {
                                    let modal = new bootstrap.Modal(document.getElementById(`modal${item.id_materia_prima}`));
                                    modal.show();
                                }
                            });

                            row.innerHTML = `
                                <td>${item.id_materia_prima}</td>
                                <td>${item.mat_pri_nombre}</td>
                                <td>${item.mat_pri_cantidad}</td>
                                <td>
                                    <a href="/materia-prima-editar/${item.id_materia_prima}" class="btn btn-success">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-danger delete-btn" data-id="${item.id_materia_prima}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            `;

                            tableBody.appendChild(row);

                            // Agregar el modal después de la tabla
                            let modal = document.createElement("div");
                            modal.innerHTML = `
                                <div class="modal fade" id="modal${item.id_materia_prima}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detalles de ${item.mat_pri_nombre}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>ID:</strong> ${item.id_materia_prima}</p>
                                                <p><strong>Nombre:</strong> ${item.mat_pri_nombre}</p>
                                                <p><strong>Descripción:</strong> ${item.mat_pri_descripcion}</p>
                                                <p><strong>Unidad de Medida:</strong> ${item.mat_pri_unidad_medida}</p>
                                                <p><strong>Cantidad:</strong> ${item.mat_pri_cantidad}</p>
                                                <p><strong>Fecha de compra:</strong> ${item.fecha_compra_mp}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            document.body.appendChild(modal);
                        });

                        // Evento para eliminar sin confirmación
                        document.querySelectorAll(".delete-btn").forEach(button => {
                            button.addEventListener("click", function (event) {
                                event.stopPropagation(); // Evita que se abra el modal
                                let id = this.getAttribute("data-id");

                                fetch(`http://localhost:8000/api/materia-prima/${id}`, {
                                    method: "DELETE",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "Accept": "application/json"
                                    }
                                })
                                .then(data => {
                                    this.closest("tr").remove(); // Elimina la fila de la tabla sin recargar
                                })
                                .catch(error => console.error("Error eliminando la materia prima:", error));
                            });
                        });
                    }
                })
                .catch(error => console.error("Error cargando los datos:", error));
        });
    </script>
</x-app-layout>
