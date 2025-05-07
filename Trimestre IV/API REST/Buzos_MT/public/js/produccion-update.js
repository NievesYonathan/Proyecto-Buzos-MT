function actualizarProduccion(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const produccionId = formData.get('produccion_id');
    
    // Datos de producción
    const produccionData = {
        produccion_nombre: formData.get('produccion_nombre'),
        produccion_fecha_fin: formData.get('produccion_fecha_fin'),
        produccion_cantidad: parseInt(formData.get('produccion_cantidad')),
        produccion_etapa: parseInt(formData.get('produccion_etapa'))
    };
    console.log('Datos de producción a enviar:', produccionData);

    // Datos de tareas
    const tareasData = [];
    const idRegistroET = formData.getAll('idRegistroET[]');
    const tareas = formData.getAll('produccion_tarea[]');
    const responsables = formData.getAll('produccion_responsable[]');
    const fechasEntrega = formData.getAll('produccion_fecha_entrega[]');

    for (let i = 0; i < tareas.length; i++) {
        tareasData.push({
            id_empleado_tarea: idRegistroET[i],
            tarea_id_tarea: tareas[i],
            empleados_num_doc: responsables[i],
            emp_tar_fecha_entrega: fechasEntrega[i],
            emp_tar_estado_tarea: 1
        });
    }

    // Datos de materias primas
    const materiasData = [];
    const idRegistroMP = formData.getAll('idRegistroMP[]');
    const materiasPrimas = formData.getAll('produccion_mtPrima[]');
    const cantidades = formData.getAll('mtPrima_cantidad[]');

    for (let i = 0; i < materiasPrimas.length; i++) {
        materiasData.push({
            id_registro: idRegistroMP[i],                         // Coincide con el controlador
            id_pro_materia_prima: materiasPrimas[i],             // Coincide con el controlador
            reg_pmp_cantidad_usada: cantidades[i]                 // Coincide con el controlador
        });
    }

    // Llamadas a las APIs
    Promise.all([
        fetch(`/api/produccion-editar/${produccionId}`, {
            method: 'PUT',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json, text/html',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(produccionData)
        }).then(async response => {
            if (!response.ok) {
                const errorData = await response.json();
                console.log('Respuesta del servidor:', errorData);
                throw new Error(`Error en producción: ${JSON.stringify(errorData)}`);
            }
            return response.json();
        }),
        fetch(`/api/produccion-tareas-editar`, {
            method: 'PUT',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json, text/html',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(tareasData)
        }),
        fetch(`/api/editar-materiaPrima`, {
            method: 'PUT',
            headers: { 
                'Content-Type': 'application/json',
                'Accept': 'application/json, text/html',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(materiasData)
        })
    ])
    .then(responses => {
        // Verificar si alguna respuesta no fue exitosa
        responses.forEach((response, index) => {
            if (!response.ok) {
                throw new Error(`Error en la petición ${index + 1}: ${response.status}`);
            }
        });
        return Promise.all(responses.map(r => r.json()));
    })
    .then(data => {
        console.log('Respuestas:', data);
        window.location.href = '/productos-fabricados'; // Redirigir a la vista específica
    })
    .catch(error => {
        console.error('Error detallado:', error);
        alert(`Error al actualizar: ${error.message}`);
    });
}