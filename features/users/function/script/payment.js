document.addEventListener('DOMContentLoaded', function() {
    const eventTypeSelect = document.getElementById('event-type');
    const eventTypeParagraph = document.getElementById('event_type');

    if (eventTypeSelect && eventTypeParagraph) {
        eventTypeSelect.addEventListener('change', function() {
            const selectedEventType = this.value;


            eventTypeParagraph.textContent = selectedEventType;

            console.log("Selected Event Type: ", selectedEventType);
        });
    }
});