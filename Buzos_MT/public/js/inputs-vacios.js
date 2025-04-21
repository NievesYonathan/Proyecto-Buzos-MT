document.addEventListener('submit', function(e) {
    if (e.target.matches('form')) {
        // Handle raw materials inputs
        const cantidades = e.target.querySelectorAll('input[name="mtPrima_cantidad[]"]');
        const materiasPrimas = e.target.querySelectorAll('select[name="produccion_mtPrima[]"]');

        for (let i = 0; i < cantidades.length; i++) {
            if (!cantidades[i].value || isNaN(cantidades[i].value) || !materiasPrimas[i].value) {
                cantidades[i].disabled = true;
                materiasPrimas[i].disabled = true;
            }
        }

        // Handle tasks inputs
        const tareas = e.target.querySelectorAll('select[name="produccion_tarea[]"]');
        const responsables = e.target.querySelectorAll('select[name="produccion_responsable[]"]');
        const fechas = e.target.querySelectorAll('input[name="produccion_fecha_entrega[]"]');

        for (let i = 0; i < tareas.length; i++) {
            if (!tareas[i].value || !responsables[i].value || !fechas[i].value) {
                tareas[i].disabled = true;
                responsables[i].disabled = true;
                fechas[i].disabled = true;
            }
        }

        // Remove template rows from submission
        const templateRows = e.target.querySelectorAll('.d-none');
        templateRows.forEach(row => {
            const templateInputs = row.querySelectorAll('input, select');
            templateInputs.forEach(input => input.disabled = true);
        });
    }
});
