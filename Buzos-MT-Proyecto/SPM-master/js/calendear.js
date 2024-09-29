const myModal = new bootstrap.Modal(document.getElementById('productionModal'))
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,
        locale: 'es',
        dateClick: function(info) {
            document.getElementById('productionDate').value = info.dateStr;
            myModal.show();
        }
    });

    calendar.render();
});


// Función para nuevos inputs de tareas
document.getElementById('addTareaBtn').addEventListener('click', function() {
    const container = document.getElementById('tarea-container'); // Contenedor del select de tarea.
    const originalSelect = document.getElementById('produccion_tarea1'); // Select de tarea.
    const addButton = document.getElementById('addTareaBtn'); // Botón de agregar nueva tarea.

    // Crear div que actúe como fila para agrupar los select de "Tarea", "Responsable" y el botón.
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-2');

    const newTaskInput = document.createElement('div'); // Crear div con las clases 'col' para 'Tarea'.
    newTaskInput.classList.add('col-12', 'col-md-4');

    const newTaskInput2 = document.createElement('div'); // Crear div con las clases 'form-group' para 'Tarea'.
    newTaskInput2.classList.add('form-group');
    newTaskInput.appendChild(newTaskInput2); // Ingresar el div 'form-group' dentro del div 'col'.

    // Clonar el select original 'Tarea'.
    const newTaskSelect = originalSelect.cloneNode(true);
    newTaskInput2.appendChild(newTaskSelect); // Ingresar el select 'Tarea' dentro del div 'form-group'.

    //------------------

    const originalSelectR = document.getElementById('produccion_responsable1'); // Select de responsable.

    const newTaskInputR = document.createElement('div'); // Crear div con las clases 'col' para 'Responsable'.
    newTaskInputR.classList.add('col-12', 'col-md-3');

    const newTaskInput2R = document.createElement('div'); // Crear div con las clases 'form-group' para 'Responsable'.
    newTaskInput2R.classList.add('form-group');
    newTaskInputR.appendChild(newTaskInput2R); // Ingresar el div 'form-group' dentro del div 'col'.

    // Clonar el select original 'Responsable'.
    const newTaskSelectR = originalSelectR.cloneNode(true);
    newTaskInput2R.appendChild(newTaskSelectR); // Ingresar el select 'Responsable' dentro del div 'form-group'.

    //------------------

    const originalInputDate = document.getElementById('produccion_fecha_entrega1'); // Select de responsable.

    const newTaskInputD = document.createElement('div'); // Crear div con las clases 'col' para 'Responsable'.
    newTaskInputD.classList.add('col-12', 'col-md-3');

    const newTaskInput2D = document.createElement('div'); // Crear div con las clases 'form-group' para 'Responsable'.
    newTaskInput2D.classList.add('form-group');
    newTaskInputD.appendChild(newTaskInput2D); // Ingresar el div 'form-group' dentro del div 'col'.

    // Clonar el select original 'Responsable'.
    const newTaskInputDate = originalInputDate.cloneNode(true);
    newTaskInput2D.appendChild(newTaskInputDate); // Ingresar el select 'Responsable' dentro del div 'form-group'.

    //------------------

    // Crear el botón de eliminar.
    const divButton = document.createElement('div'); // Crear div para el botón de eliminar.
    divButton.classList.add('col-12', 'col-md-2', 'd-flex', 'align-items-center');

    const removeButton = document.createElement('button');
    removeButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
    removeButton.classList.add('btn', 'btn-danger', 'w-100'); // Botón de eliminar ocupa el 100% del ancho del div.

    // Agregar el botón de eliminar al divButton.
    divButton.appendChild(removeButton);

    // Agregar evento para eliminar la fila completa (inputs y botón) cuando se presione el botón.
    removeButton.addEventListener('click', function() {
        newRow.remove();  // Eliminar la fila completa que contiene los selects y el botón.
    });

    // Agregar los inputs de "Tarea", "Responsable" y el botón a la fila.
    newRow.appendChild(newTaskInput);
    newRow.appendChild(newTaskInputR);
    newRow.appendChild(newTaskInputD);
    newRow.appendChild(divButton);

    // Insertar la fila antes del botón de agregar.
    container.insertBefore(newRow, addButton.parentNode);
});

// Función para nuevos inputs de Materia Prima
document.getElementById('addMtPrimaBtn').addEventListener('click', function() {
    const container = document.getElementById('mtPrima-container'); // Contenedor del select de tarea.
    const originalSelect = document.getElementById('produccion_mtPrima1'); // Select de tarea.
    const addButton = document.getElementById('addMtPrimaBtn'); // Botón de agregar nueva tarea.

    // Crear div que actúe como fila para agrupar los select de "Tarea", "Responsable" y el botón.
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mt-2');

    const newTaskInput = document.createElement('div'); // Crear div con las clases 'col' para 'Tarea'.
    newTaskInput.classList.add('col-12', 'col-md-5');

    const newTaskInput2 = document.createElement('div'); // Crear div con las clases 'form-group' para 'Tarea'.
    newTaskInput2.classList.add('form-group');
    newTaskInput.appendChild(newTaskInput2); // Ingresar el div 'form-group' dentro del div 'col'.

    // Clonar el select original 'Tarea'.
    const newTaskSelect = originalSelect.cloneNode(true);
    newTaskInput2.appendChild(newTaskSelect); // Ingresar el select 'Tarea' dentro del div 'form-group'.

    //------------------

    const originalSelectR = document.getElementById('mtPrima_cantidad1'); // Select de responsable.

    const newTaskInputR = document.createElement('div'); // Crear div con las clases 'col' para 'Responsable'.
    newTaskInputR.classList.add('col-12', 'col-md-5');

    const newTaskInput2R = document.createElement('div'); // Crear div con las clases 'form-group' para 'Responsable'.
    newTaskInput2R.classList.add('form-group');
    newTaskInputR.appendChild(newTaskInput2R); // Ingresar el div 'form-group' dentro del div 'col'.

    // Clonar el select original 'Responsable'.
    const newTaskSelectR = originalSelectR.cloneNode(true);
    newTaskInput2R.appendChild(newTaskSelectR); // Ingresar el select 'Responsable' dentro del div 'form-group'.

    //------------------

    // Crear el botón de eliminar.
    const divButton = document.createElement('div'); // Crear div para el botón de eliminar.
    divButton.classList.add('col-12', 'col-md-2', 'd-flex', 'align-items-center');

    const removeButton = document.createElement('button');
    removeButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
    removeButton.classList.add('btn', 'btn-danger', 'w-100'); // Botón de eliminar ocupa el 100% del ancho del div.

    // Agregar el botón de eliminar al divButton.
    divButton.appendChild(removeButton);

    // Agregar evento para eliminar la fila completa (inputs y botón) cuando se presione el botón.
    removeButton.addEventListener('click', function() {
        newRow.remove();  // Eliminar la fila completa que contiene los selects y el botón.
    });

    // Agregar los inputs de "Tarea", "Responsable" y el botón a la fila.
    newRow.appendChild(newTaskInput);
    newRow.appendChild(newTaskInputR);
    newRow.appendChild(divButton);

    // Insertar la fila antes del botón de agregar.
    container.insertBefore(newRow, addButton.parentNode);
});

