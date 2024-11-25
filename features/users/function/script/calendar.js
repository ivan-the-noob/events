document.addEventListener('DOMContentLoaded', async function () {
    const calendarEl = document.getElementById('calendar');

    let unavailableDays = [];
    try {
        const response = await fetch('../function/php/unavailable.php');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        unavailableDays = await response.json();
    } catch (error) {
        console.error('Error fetching unavailable days:', error);
    }

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

                info.el.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                });
            } 
            else if (unavailableDays.includes(selectedDate)) {
                info.el.style.backgroundColor = '#FFBFBD'; 
                info.el.style.setProperty('color', '#FFBFBD', 'important');
                info.el.style.opacity = 1; 
                info.el.style.cursor = 'not-allowed';

                info.el.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                });
            } else {
                try {
                    const response = await fetch(`../function/php/check_date_availability.php?date=${selectedDate}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.bookings >= 2) {
                        info.el.style.backgroundColor = '#D2B48C';
                        info.el.style.cursor = 'not-allowed';
                        info.el.style.setProperty('color', 'white', 'important');

                        info.el.addEventListener('click', (e) => {
                            e.stopPropagation();
                            e.preventDefault();
                        });
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

                        info.el.addEventListener('click', function () {
                            document.getElementById('events-date').value = selectedDate;

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
