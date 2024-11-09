const eventPackageSelect = document.getElementById('event-package');
const eventOptionsGroup = document.getElementById('event-options-group');
const checkboxes = document.querySelectorAll('input[name="event_options[]"]');

eventPackageSelect.addEventListener('change', function() {
    console.log("Selected Package: ", this.value);

    if (this.value === 'Other') {
        eventOptionsGroup.style.display = 'block';
    } else {
        eventOptionsGroup.style.display = 'none';

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });

        console.log("Checkboxes unchecked");
    }
});
