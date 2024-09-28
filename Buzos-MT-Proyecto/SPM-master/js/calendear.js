const myModal = new bootstrap.Modal(document.getElementById('productionModal'))
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,
        selectable: true,
        dateClick: function(info) {
            //console.log(info);
            // Guardar la fecha seleccionada
            document.getElementById('productionDate').value = info.dateStr;
            // Abrir el modal
            //var modal = new bootstrap.Modal(document.getElementById('productionModal'));
            mymodal.show();
        },
    });

    calendar.render();
});
