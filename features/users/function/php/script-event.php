<script>
document.getElementById('event-type').addEventListener('change', function() {
    // Hide all options initially
    document.querySelectorAll('[id$="-options"]').forEach(function(el) {
        el.style.display = 'none';
    });

    const selectedEvent = this.selectedOptions[0].getAttribute('data-type'); // Get the formatted value
    const selectedOptions = document.getElementById(selectedEvent +
        '-options'); // Match with the event options id

    if (selectedOptions) {
        selectedOptions.style.display = 'block';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id$="-options"]').forEach(function(el) {
        el.style.display = 'none'; // Hide all event options initially
    });

    // Additional package-specific logic for each event
    document.querySelectorAll('[id$="-package"]').forEach(function(select) {
        select.addEventListener('change', function() {
            const selectedPackage = this.value;
            const eventType = this.id.split('-')[
                0]; // Get event type from the ID (e.g., "kiddie-party")
            const optionsId = eventType + '-options';
            const otherOptionsId = 'Other-' + eventType + '-options';
            const otherOptions = document.getElementById(otherOptionsId);

            if (selectedPackage === 'Other-' + eventType) {
                otherOptions.style.display = 'block';
            } else {
                otherOptions.style.display = 'none';
            }
        });
    });
});
</script>