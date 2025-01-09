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
 
            if (selectedDateStr < todayStr) { 
                info.el.style.backgroundColor = 'white'; 
                info.el.style.opacity = 0.2; 
                info.el.style.cursor = 'not-allowed'; 
            } 
            else if (unavailableDays.includes(selectedDateStr)) { 
                info.el.style.backgroundColor = '#FFBFBD'; 
                info.el.style.cursor = 'not-allowed'; 
            } 
            else { 
                try { 
                    const response = await fetch(`../function/php/check_date_availability.php?date=${selectedDateStr}`); 
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
        }, 
    }); 
 
    calendar.render(); 
});