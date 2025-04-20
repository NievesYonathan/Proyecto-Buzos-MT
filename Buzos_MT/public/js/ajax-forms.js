document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ajax-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = this.getAttribute('action');
            const method = formData.get('_method') || this.method;

            // Deshabilitar campos vacíos antes del envío
            const emptyInputs = this.querySelectorAll('input[value=""], select:not(:checked)');
            emptyInputs.forEach(input => input.disabled = true);

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 200 || data.status === 201) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message || 'Actualización exitosa',
                        timer: 1500
                    }).then(() => {
                        // Recargar solo los datos necesarios o actualizar la vista parcialmente
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Error en la actualización');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message
                });
            })
            .finally(() => {
                // Rehabilitar campos
                emptyInputs.forEach(input => input.disabled = false);
            });
        });
    });
});