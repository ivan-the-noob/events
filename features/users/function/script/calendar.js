document.addEventListener('DOMContentLoaded', async function () {
    const calendarEl = document.getElementById('calendar');

    // Fetch unavailable days dynamically from the PHP endpoint
    let unavailableDays = [];
    try {
        const response = await fetch('../function/php/unavailable.php');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        unavailableDays = await response.json(); // Fetch unavailable days as an array
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

            // Check if the date is in the past or is unavailable
            if (selectedDate < today || unavailableDays.includes(selectedDate)) {
                info.el.style.backgroundColor = '#D3D3D3'; // Grey background for past or unavailable dates
                info.el.style.cursor = 'not-allowed';

                // Disable click on these date cells
                info.el.addEventListener('click', (e) => {
                    e.stopPropagation();
                    e.preventDefault();
                });
            } else {
                // Continue with bookings logic if the date is not in the past or unavailable
                try {
                    const response = await fetch(`../function/php/check_date_availability.php?date=${selectedDate}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.bookings >= 2) {
                        info.el.style.backgroundColor = '#FFBFBD'; // Red for fully booked
                        info.el.style.cursor = 'not-allowed';

                        info.el.addEventListener('click', (e) => {
                            e.stopPropagation();
                            e.preventDefault();
                        });
                    } else {
                        info.el.style.backgroundColor = '#DDFFCC'; // Greenish for available dates

                        info.el.addEventListener('mouseenter', function () {
                            info.el.style.backgroundColor = '#100E44'; // Dark blue on hover
                            info.el.style.color = '#FFFFFF'; 
                        });

                        info.el.addEventListener('mouseleave', function () {
                            info.el.style.backgroundColor = '#DDFFCC'; // Reset greenish
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
