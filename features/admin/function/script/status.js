function updateStatus(selectElement, bookingId) {
    const status = selectElement.value;

    selectElement.classList.remove('bg-warning', 'bg-info', 'bg-success');  

    if (status === 'Waiting') {
        selectElement.classList.add('bg-warning');  
    } else if (status === 'On-going') {
        selectElement.classList.add('bg-primary');
        selectElement.classList.add('text-white');   
    } else if (status === 'Finished') {
        selectElement.classList.add('bg-success');  
        selectElement.classList.add('text-white'); 
    }

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

    xhr.send("id=" + bookingId + "&status=" + encodeURIComponent(status));
}

function setInitialBackgroundColor() {
    const selectElements = document.querySelectorAll('.form-select');

    selectElements.forEach(function(selectElement) {
        const status = selectElement.value;

        if (status === 'Waiting') {
            selectElement.classList.add('bg-warning');  
        } else if (status === 'On-going') {
            selectElement.classList.add('bg-primary');
            selectElement.classList.add('text-white');     
        } else if (status === 'Finished') {
            selectElement.classList.add('bg-success'); 
            selectElement.classList.add('text-white'); 
        }
    });
}

window.onload = function() {
    setInitialBackgroundColor();  
}
