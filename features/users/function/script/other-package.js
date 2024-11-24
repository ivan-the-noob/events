
  document.getElementById('event-type').addEventListener('change', function () {
    document.querySelectorAll('[id$="-options"]').forEach(function (el) {
        el.style.display = 'none';
    });

    const selectedEvent = this.value
        .toLowerCase()
        .replace(/ /g, '-') 
        .replace(/\//g, ''); 

    const selectedOptions = document.getElementById(selectedEvent + '-options');
    if (selectedOptions) {
        selectedOptions.style.display = 'block';
    }
});

document.querySelectorAll('[id$="-package"]').forEach(function(selectElement) {
    selectElement.addEventListener('change', function () {
        const eventType = this.closest('.form-group').id.replace('-options', '');
        const selectedPackage = this.value;

        const eventOptionsGroup = document.getElementById('event-options-group');
        const checkboxes = eventOptionsGroup.querySelectorAll('input[name="event_options[]"]');

        console.log("Selected Package: ", selectedPackage);

        if (selectedPackage === 'Other') {
            eventOptionsGroup.style.display = 'block';
        } else {
            eventOptionsGroup.style.display = 'none';

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            console.log("Checkboxes unchecked");
        }
    });
});