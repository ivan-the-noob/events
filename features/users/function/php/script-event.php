<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const eventTypeId = this.getAttribute('data-id');
            const eventTypeName = this.getAttribute('data-event_name');
            
            fetchEventPackages(eventTypeId);

            document.getElementById('event-options').style.display = 'block';
        });
    });

    function fetchEventPackages(eventTypeId) {
        fetch('../function/get_event_packages.php?event_type_id=' + eventTypeId)
            .then(response => response.json())
            .then(data => {
                const packageSelect = document.getElementById('event-package');
                packageSelect.innerHTML = '<option value="" disabled selected>Select a package</option>'; // Clear previous options

                data.forEach(function (packageItem) {
                    const option = document.createElement('option');
                    option.value = packageItem.id;
                    option.textContent = `${packageItem.package_name} - ₱${packageItem.price.toLocaleString()}`;
                    packageSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching event packages:', error);
            });
    }
});

</script>