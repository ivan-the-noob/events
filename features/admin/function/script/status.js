function updateStatus(selectElement, bookingId) {
    const status = selectElement.value;

    // Remove all previous background color classes
    selectElement.classList.remove('bg-warning', 'bg-info', 'bg-success');  

    // Apply the background color based on the status
    if (status === 'Waiting') {
        selectElement.classList.add('bg-warning');  
    } else if (status === 'On-going') {
        selectElement.classList.add('bg-success');
        selectElement.classList.add('text-white');   
    } else if (status === 'Finished') {
        selectElement.classList.add('bg-success');  
    }

    // Send the updated status to the server using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../function/php/update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); 
            if (xhr.responseText.trim() === "success") {
                Swal.fire({
                    title: 'Success!',
                    text: 'Status updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
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

    // Send the booking ID and status to the server
    xhr.send("id=" + bookingId + "&status=" + encodeURIComponent(status));
}

// Function to set the initial background color when the page loads
function setInitialBackgroundColor() {
    const selectElements = document.querySelectorAll('.form-select');

    selectElements.forEach(function(selectElement) {
        const status = selectElement.value;

        // Apply the appropriate background color based on the status
        if (status === 'Waiting') {
            selectElement.classList.add('bg-warning');  
        } else if (status === 'On-going') {
            selectElement.classList.add('bg-success');
            selectElement.classList.add('text-white');     
        } else if (status === 'Finished') {
            selectElement.classList.add('bg-success'); 
        }
    });
}

// Call setInitialBackgroundColor when the page loads
window.onload = function() {
    setInitialBackgroundColor();  
}
