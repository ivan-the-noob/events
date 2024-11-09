const durationSelect = document.getElementById('event-duration');
const startTimeSelect = document.getElementById('event-starttime');
const endTimeInput = document.getElementById('event-endtime');

function calculateEndTime() {
  const startHour = parseInt(startTimeSelect.value);
  const duration = parseInt(durationSelect.value);

  if (!isNaN(startHour) && !isNaN(duration)) {
    let endHour = startHour + duration;
    if (endHour > 24) endHour -= 24; 

    const endTime = new Date();
    endTime.setHours(endHour, 0, 0);

    const options = { hour: 'numeric', minute: 'numeric', hour12: true };
    endTimeInput.value = endTime.toLocaleTimeString('en-US', options);
  } else {
    endTimeInput.value = '';
  }
}

durationSelect.addEventListener('change', calculateEndTime);
startTimeSelect.addEventListener('change', calculateEndTime);