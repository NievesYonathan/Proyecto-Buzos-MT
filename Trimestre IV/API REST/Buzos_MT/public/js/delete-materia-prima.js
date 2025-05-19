document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-mtprima-btn')) {
        const btn = e.target.closest('.delete-mtprima-btn');
        const id = btn.dataset.id;
        
        if (!id) return;

        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea eliminar esta materia prima?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/api/eliminar-materiaPrima/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        btn.closest('.row').remove();
                        Swal.fire(
                            '¡Eliminado!',
                            'La materia prima ha sido eliminada.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar la materia prima.',
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error',
                        'Hubo un problema al eliminar la materia prima.',
                        'error'
                    );
                });
            }
        });
    }
});