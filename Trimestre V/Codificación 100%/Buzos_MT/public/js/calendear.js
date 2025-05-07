const myModal = new bootstrap.Modal(document.getElementById('productionModal'))
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('productionDate_inicio').value = today;

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,
        locale: 'es',
        dateClick: function(info) {
            const clickedDate = info.dateStr;

            if (clickedDate < today) {
                // Aquí puedes mostrar un mensaje si quieres
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha no válida',
                    text: 'No puedes seleccionar fechas pasadas.',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            document.getElementById('productionDate_fin').value = clickedDate;
            myModal.show();
        }
    });

    calendar.render();
});
