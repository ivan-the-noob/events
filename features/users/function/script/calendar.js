document.addEventListener('DOMContentLoaded', async function () {
    const calendarEl = document.getElementById('calendar');
    const eventStarttimeSelect = document.getElementById('event-starttime');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            right: 'prev,next',
        },
        dayCellDidMount: async function (info) {
            const selectedDate = info.date.toISOString().split('T')[0];
            const today = new Date().toISOString().split('T')[0];

            if (selectedDate < today) {
                info.el.style.backgroundColor = 'white';
                info.el.style.opacity = 0.2;
                info.el.style.cursor = 'not-allowed';
            } else {
                try {
                    const response = await fetch(`../function/php/check_date_availability.php?date=${selectedDate}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.bookings_count >= 2) {
                        info.el.style.backgroundColor = '#D2B48C';
                        info.el.style.cursor = 'not-allowed';
                        info.el.style.setProperty('color', 'white', 'important');
                    } else {
                        info.el.style.backgroundColor = '#FFFFFF'; 

                        info.el.addEventListener('mouseenter', function () {
                            info.el.style.backgroundColor = '#100E44';
                            info.el.style.color = '#FFFFFF';
                        });

                        info.el.addEventListener('mouseleave', function () {
                            info.el.style.backgroundColor = '#FFFFFF';
                            info.el.style.color = ''; 
                        });

                        info.el.addEventListener('click', async function () {
                            document.getElementById('events-date').value = selectedDate;

                            Array.from(eventStarttimeSelect.options).forEach(option => {
                                option.hidden = false;
                            });

                            if (Array.isArray(result.booked_times)) {
                                result.booked_times.forEach(startTime => {
                                    const startTimeInt = parseInt(startTime, 10);
                                    for (let i = 0; i <= 5; i++) {
                                        const option = eventStarttimeSelect.querySelector(`option[value='${startTimeInt + i}']`);
                                        if (option) {
                                            option.hidden = true;
                                        }
                                    }

                                    for (let i = 1; i <= 5; i++) {
                                        const option = eventStarttimeSelect.querySelector(`option[value='${startTimeInt - i}']`);
                                        if (option) {
                                            option.hidden = true;
                                        }
                                    }
                                });
                            }

                            const myModal = new bootstrap.Modal(document.getElementById('dateModal'), {
                                keyboard: false,
                            });
                            myModal.show();
                        });
                    }
                } catch (error) {
                    console.error('Error fetching availability:', error);
                }
            }
        },
    });

    calendar.render();
});
