const eventPackageSelect = document.getElementById('event-package');
const eventOptionsGroup = document.getElementById('event-options-group');

eventPackageSelect.addEventListener('change', function() {
    if (this.value === 'Other') {
    eventOptionsGroup.style.display = 'block';
    } else {
    eventOptionsGroup.style.display = 'none';
    }
});