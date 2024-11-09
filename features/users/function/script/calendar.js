document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            right: 'prev,next'
        },
        dayCellDidMount: function (info) {
            info.el.addEventListener('click', function () {
                document.getElementById('modalDate').textContent = info.date.toISOString().split('T')[0];
                var myModal = new bootstrap.Modal(document.getElementById('dateModal'), {
                    keyboard: false
                });
                myModal.show();
            });
        },
    });

    calendar.render();
});
