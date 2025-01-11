function updateStatus(selectElement, bookingId) {
    const status = selectElement.value;

    // Remove all status-related classes
    selectElement.classList.remove(
        'bg-warning',
        'bg-info',
        'bg-success',
        'bg-primary',
        'bg-danger',
        'text-white'
    );

    // Add classes based on the selected status
    switch (status) {
        case 'Waiting':
            selectElement.classList.add('bg-warning');
            break;
        case 'On-going':
            selectElement.classList.add('bg-primary', 'text-white');
            break;
        case 'Finished':
            selectElement.classList.add('bg-success', 'text-white');
            break;
        case 'Cancel':
            selectElement.classList.add('bg-danger', 'text-white');
            break;
        case 'Update-payment':
            selectElement.classList.add('bg-info', 'text-white');
            const modal = new bootstrap.Modal(document.getElementById('updatePaymentModal'));
            modal.show();     
            document.getElementById('bookingId').value = bookingId;
            return;
        case 'resched':
            selectElement.classList.add('bg-warning', 'text-white');
            break;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../function/php/update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            if (xhr.responseText.trim() === "success") {
                if (status !== 'Update-payment') {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Status updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update status: ' + xhr.responseText,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    };

    xhr.send("id=" + bookingId + "&status=" + encodeURIComponent(status));
}

function handleModalSubmit(event) {
    event.preventDefault();  

    const form = event.target;
    const formData = new FormData(form);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", form.action, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText.trim() === "success") {
                const modal = bootstrap.Modal.getInstance(document.getElementById('updatePaymentModal'));
                modal.hide();

                Swal.fire({
                    title: 'Success!',
                    text: 'Second payment updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
               
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update second payment: ' + xhr.responseText,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    };

    xhr.send(formData);
}
