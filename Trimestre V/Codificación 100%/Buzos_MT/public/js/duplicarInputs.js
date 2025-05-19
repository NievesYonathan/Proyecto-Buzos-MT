document.addEventListener('DOMContentLoaded', function () {
    // Función para nuevos inputs de tareas
    document.querySelectorAll('.add-tarea-btn').forEach(button => {
        button.addEventListener('click', function () {
            const modal = this.closest('.modal');
            const container = modal.querySelector('.tarea-container');
            
            let template = modal.querySelector('.tarea-container .d-none');
            if (!template) {
                template = container.querySelector('.produccion-tarea')?.closest('.row');
            }

            if (template) {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-2');

                // Crear contenedor para Tarea
                const newTaskInput = document.createElement('div');
                newTaskInput.classList.add('col-12', 'col-md-4');
                const newTaskInput2 = document.createElement('div');
                newTaskInput2.classList.add('form-group');
                const newTaskSelect = template.querySelector('.produccion-tarea').cloneNode(true);
                newTaskSelect.value = '';
                newTaskInput2.appendChild(newTaskSelect);
                newTaskInput.appendChild(newTaskInput2);

                // Crear contenedor para Responsable
                const newTaskInputR = document.createElement('div');
                newTaskInputR.classList.add('col-12', 'col-md-3');
                const newTaskInput2R = document.createElement('div');
                newTaskInput2R.classList.add('form-group');
                const newTaskSelectR = template.querySelector('.produccion-responsable').cloneNode(true);
                newTaskSelectR.value = '';
                newTaskInput2R.appendChild(newTaskSelectR);
                newTaskInputR.appendChild(newTaskInput2R);

                // Crear contenedor para Fecha
                const newTaskInputD = document.createElement('div');
                newTaskInputD.classList.add('col-12', 'col-md-3');
                const newTaskInput2D = document.createElement('div');
                newTaskInput2D.classList.add('form-group');
                const newTaskInputDate = template.querySelector('.produccion-fecha').cloneNode(true);
                newTaskInputDate.value = '';
                newTaskInput2D.appendChild(newTaskInputDate);
                newTaskInputD.appendChild(newTaskInput2D);

                // Crear botón eliminar
                const divButton = document.createElement('div');
                divButton.classList.add('col-12', 'col-md-2', 'd-flex', 'align-items-center');
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                removeButton.classList.add('btn', 'btn-danger', 'w-100');
                divButton.appendChild(removeButton);
                removeButton.addEventListener('click', () => newRow.remove());

                // Agregar todos los elementos
                newRow.appendChild(newTaskInput);
                newRow.appendChild(newTaskInputR);
                newRow.appendChild(newTaskInputD);
                newRow.appendChild(divButton);

                container.insertBefore(newRow, this.parentNode);
            }
        });
    });

    // Función para nuevos inputs de Materia Prima
    document.querySelectorAll('.add-mtprima-btn').forEach(button => {
        button.addEventListener('click', function () {
            const modal = this.closest('.modal');
            const container = modal.querySelector('.mtprima-container');
            
            // Obtener el template oculto o el primer elemento existente
            let template = modal.querySelector('.mtprima-container .d-none');
            if (!template) {
                template = container.querySelector('.materia-prima-select')?.closest('.row');
            }

            if (template) {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mt-2');

                // Crear contenedor para Materia Prima
                const newTaskInput = document.createElement('div');
                newTaskInput.classList.add('col-12', 'col-md-5');
                const newTaskInput2 = document.createElement('div');
                newTaskInput2.classList.add('form-group');
                const newTaskSelect = template.querySelector('.materia-prima-select').cloneNode(true);
                newTaskSelect.value = '';
                newTaskInput2.appendChild(newTaskSelect);
                newTaskInput.appendChild(newTaskInput2);

                // Crear contenedor para Cantidad
                const newTaskInputR = document.createElement('div');
                newTaskInputR.classList.add('col-12', 'col-md-5');
                const newTaskInput2R = document.createElement('div');
                newTaskInput2R.classList.add('form-group');
                const newTaskInputCantidad = template.querySelector('.cantidad-input').cloneNode(true);
                newTaskInputCantidad.value = '';
                newTaskInput2R.appendChild(newTaskInputCantidad);
                newTaskInputR.appendChild(newTaskInput2R);

                // Crear botón eliminar
                const divButton = document.createElement('div');
                divButton.classList.add('col-12', 'col-md-2', 'd-flex', 'align-items-center');
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                removeButton.classList.add('btn', 'btn-danger', 'w-100');
                divButton.appendChild(removeButton);
                removeButton.addEventListener('click', () => newRow.remove());

                // Agregar todos los elementos
                newRow.appendChild(newTaskInput);
                newRow.appendChild(newTaskInputR);
                newRow.appendChild(divButton);

                container.insertBefore(newRow, this.parentNode);
            }
        });
    });
});


