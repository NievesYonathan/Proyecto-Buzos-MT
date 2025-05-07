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

