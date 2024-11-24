  // Event listener for the 'event-type' dropdown
  document.getElementById('event-type').addEventListener('change', function () {
    // Hide all event options sections initially
    document.querySelectorAll('[id$="-options"]').forEach(function (el) {
        el.style.display = 'none';
    });

    // Get the selected event type and format it to match the ids of the options
    const selectedEvent = this.value
        .toLowerCase()
        .replace(/ /g, '-') // replace spaces with hyphens
        .replace(/\//g, ''); // remove slashes

    // Show the corresponding options for the selected event type
    const selectedOptions = document.getElementById(selectedEvent + '-options');
    if (selectedOptions) {
        selectedOptions.style.display = 'block';
    }
});

// Event listener for the 'event-package' dropdown (inside each event type options)
document.querySelectorAll('[id$="-package"]').forEach(function(selectElement) {
    selectElement.addEventListener('change', function () {
        // Get the event type and package selected
        const eventType = this.closest('.form-group').id.replace('-options', '');
        const selectedPackage = this.value;

        // Find the event options group (checkboxes) related to the event package
        const eventOptionsGroup = document.getElementById('event-options-group');
        const checkboxes = eventOptionsGroup.querySelectorAll('input[name="event_options[]"]');

        console.log("Selected Package: ", selectedPackage);

        if (selectedPackage === 'Other') {
            // Show the event options (checkboxes) when "Other" is selected
            eventOptionsGroup.style.display = 'block';
        } else {
            // Hide the event options if a non-"Other" package is selected
            eventOptionsGroup.style.display = 'none';

            // Uncheck all checkboxes
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            console.log("Checkboxes unchecked");
        }
    });
});