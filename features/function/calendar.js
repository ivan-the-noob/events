document.addEventListener('DOMContentLoaded', async function () { 
    const calendarEl = document.getElementById('calendar'); 
    const eventStarttimeSelect = document.getElementById('event-starttime'); 
 
    let unavailableDays = []; 
    try { 
        const response = await fetch('../function/php/unavailable.php'); 
        if (response.ok) { 
            unavailableDays = await response.json(); 
        } else { 
            console.error('Failed to fetch unavailable days:', response.status); 
        } 
    } catch (error) { 
        console.error('Error fetching unavailable days:', error); 
    } 

    console.log('Initial unavailableDays:', unavailableDays);
 
    const calendar = new FullCalendar.Calendar(calendarEl, { 
        initialView: 'dayGridMonth', 
        headerToolbar: { 
            right: 'prev,next', 
        }, 
       
        dayCellDidMount: async function (info) { 
            const selectedDate = new Date(info.date); 
            selectedDate.setHours(0, 0, 0, 0); 
            const selectedDateStr = selectedDate.toLocaleDateString('en-CA'); 
        
            const today = new Date(); 
            today.setHours(0, 0, 0, 0); 
            const todayStr = today.toLocaleDateString('en-CA'); 
        
            for (let i = 0; i <= 6; i++) {
                const futureDate = new Date(today);
                futureDate.setDate(today.getDate() + i);
                const futureDateStr = futureDate.toLocaleDateString('en-CA');
                if (!unavailableDays.includes(futureDateStr)) {
                    unavailableDays.push(futureDateStr);
                }
            }
        
            console.log('Unavailable days after today:', unavailableDays);
        
            if (selectedDateStr < todayStr) { 
                info.el.style.backgroundColor = 'white'; 
                info.el.style.opacity = 0.2; 
                info.el.style.cursor = 'not-allowed'; 
            } 
            else if (unavailableDays.includes(selectedDateStr)) { 
                info.el.style.backgroundColor = '#FFBFBD'; 
                info.el.style.cursor = 'not-allowed'; 
            } 
            document.addEventListener('DOMContentLoaded', async function () {
                const calendarEl = document.getElementById('calendar');
                const eventStarttimeSelect = document.getElementById('event-starttime');
            
                // Fetch unavailable days
                let unavailableDays = [];
                try {
                    const response = await fetch('../function/php/unavailable.php');
                    if (response.ok) {
                        unavailableDays = await response.json();
                    } else {
                        console.error('Failed to fetch unavailable days:', response.status);
                    }
                } catch (error) {
                    console.error('Error fetching unavailable days:', error);
                }
            
                console.log('Initial unavailableDays:', unavailableDays);
            
                // Calendar initialization
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        right: 'prev,next',
                    },
                    dayCellDidMount: async function (info) {
                        const selectedDate = new Date(info.date);
                        selectedDate.setHours(0, 0, 0, 0);
                        const selectedDateStr = selectedDate.toLocaleDateString('en-CA');
            
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        const todayStr = today.toLocaleDateString('en-CA');
            
                        // Disable past days
                        if (selectedDateStr < todayStr) {
                            info.el.style.backgroundColor = 'white';
                            info.el.style.opacity = 0.2;
                            info.el.style.cursor = 'not-allowed';
                        } else if (unavailableDays.includes(selectedDateStr)) {
                            // Disable unavailable days
                            info.el.style.backgroundColor = '#FFBFBD';
                            info.el.style.cursor = 'not-allowed';
                        } else {
                            try {
                                const response = await fetch(`../function/php/check_date_availability.php?date=${selectedDateStr}`);
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
            
                                const result = await response.json();
            
                                if (result.bookings_count >= 1) {
                                    console.log(`Booked Date: ${selectedDateStr}`);
                                    console.log('Booking +7 days unavailable:');
                                    // Mark the next 7 days as unavailable
                                    for (let i = 1; i <= 7; i++) {
                                        const futureDate = new Date(selectedDate);
                                        futureDate.setDate(selectedDate.getDate() + i);
                                        const futureDateStr = futureDate.toLocaleDateString('en-CA');
                                        console.log(futureDateStr);
                                        if (!unavailableDays.includes(futureDateStr)) {
                                            unavailableDays.push(futureDateStr);
                                        }
                                    }
                                    console.log('Unavailable days after booking +7 days:', unavailableDays);
                                }
            
                                console.log(`Processing Date: ${selectedDateStr}`);
                                console.log('Current unavailableDays:', unavailableDays);
            
                                if (unavailableDays.includes(selectedDateStr)) {
                                    info.el.style.backgroundColor = '#FFBFBD';
                                    info.el.style.cursor = 'not-allowed';
                                } else if (result.bookings_count >= 2) {
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
                                        document.getElementById('events-date').value = selectedDateStr;
            
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
                    }
                });
            
                // Re-render FullCalendar when the modal is shown
                $('#resched').on('shown.bs.modal', function () {
                    calendar.render();
                });
            
                // Initial rendering of the calendar
                calendar.render();
            
                // When the "Confirm Reschedule" button is clicked
                document.getElementById('confirm-reschedule').addEventListener('click', function () {
                    const newDate = document.getElementById('selected-date').value;
                    
                    // Get the booking ID from the button (stored as data attribute)
                    const bookingId = document.querySelector('[data-bs-toggle="modal"][data-bs-target="#resched"]').getAttribute('data-booking-id');
            
                    // Make sure the new date is selected
                    if (newDate) {
                        // Update the booking with new date (via Pure AJAX)
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '../function/php/reschedule.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                const response = xhr.responseText;
                                console.log('Response from reschedule:', response); // Inspect the response
                                if (response === 'Booking rescheduled successfully') {
                                    alert('Booking successfully rescheduled!');
                                    location.reload();
                                } else {
                                    alert(response); // Display error message
                                }
                            }
                        };
            
                        // Send bookingId and newDate as form data
                        const data = `bookingId=${encodeURIComponent(bookingId)}&newDate=${encodeURIComponent(newDate)}`;
                        xhr.send(data);
                    } else {
                        alert('Please select a date before confirming.');
                    }
                });
            });
            
        },
        
    }); 
 
    calendar.render(); 
}); 
