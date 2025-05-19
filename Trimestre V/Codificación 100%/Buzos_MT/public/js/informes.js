document.addEventListener('click', event => {
    if (event.target.classList.contains('clickable-col')) {
        const columnType = event.target.getAttribute('data-col');
        fetchUserData(columnType);
    }
});

function fetchUserData(columnType) {
    fetch(`/informes/users?queryType=${columnType}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const tableBody = document.getElementById('userTableBody');
            tableBody.innerHTML = ''; // Limpia los datos anteriores

            // Verifica si hay datos disponibles
            if (data.length === 0) {
                tableBody.insertAdjacentHTML('beforeend', `
                    <tr class="table-light text-center">
                        <td colspan="7" class="text-center">No se encontraron usuarios.</td>
                    </tr>
                `);
            } else {
                data.forEach(user => {
                    // Asegúrate de que estás accediendo a las relaciones correctamente
                    const tipoDoc = user.tipo_documento ? user.tipo_documento.tip_doc_descripcion : 'No disponible'; // Acceder al tipo de documento
                    const cargo = user.cargos && user.cargos.length > 0 ? user.cargos[0].car_nombre : 'No disponible'; // Acceder al cargo
                    
                    const row = `
                        <tr class="table-light text-center">
                            <td>${tipoDoc}</td>
                            <td>${user.num_doc}</td>
                            <td>${user.usu_nombres}</td>
                            <td>${user.usu_apellidos}</td>
                            <td>${user.usu_telefono}</td>
                            <td>${user.usu_email}</td>
                            <td>${cargo}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            }

            // Abre el modal después de llenar los datos
            const modal = new bootstrap.Modal(document.getElementById('userModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });
}
