
function updateEventPackageCost() {
    const selectElements = document.querySelectorAll('.form-group select[name="event_package"]');
    
    let totalCost = 0;
    const selectedDetails = [];

    selectElements.forEach(select => {
        const selectedPackage = select.querySelector('option:checked');
        
        if (selectedPackage && selectedPackage.value) {
            const selectedPackageCost = parseFloat(selectedPackage.getAttribute('data-cost')) || 0;
            totalCost += selectedPackageCost;
            selectedDetails.push(`${selectedPackage.textContent}: ₱${selectedPackageCost.toLocaleString()}`);
        }
    });

    const detailsContainer = document.getElementById('event_package');
    const costContainer = document.getElementById('cost');

    if (detailsContainer) {
        detailsContainer.innerHTML = selectedDetails.join('<br>');  
    }
    if (costContainer) {
        costContainer.textContent = `₱${totalCost.toLocaleString()}`; 
    }
}

function resetPackageSelections() {
    const selectElements = document.querySelectorAll('.form-group select[name="event_package"]');
    
    selectElements.forEach(select => {
        select.value = "";
    });


    const detailsContainer = document.getElementById('event_package');
    const costContainer = document.getElementById('cost');

    if (detailsContainer) {
        detailsContainer.innerHTML = ''; 
    }
    if (costContainer) {
        costContainer.textContent = '₱0'; 
    }
}


document.getElementById('event-type').addEventListener('change', function () {
    resetPackageSelections(); 
    updateEventPackageCost(); 
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-group select[name="event_package"]').forEach(select => {
        select.addEventListener('change', updateEventPackageCost);
    });

    updateEventPackageCost();
});

function updateSelectedDetails() {
    let totalCost = 0;
    const selectedDetails = [];

    const activeOptionsContainer = document.querySelector('.form-group[id^="Other-"]:not([style*="display: none"])');

    if (activeOptionsContainer) {
        const selectedPax = activeOptionsContainer.querySelector('input[type="radio"]:checked');
        if (selectedPax) {
            const paxText = selectedPax.value;
            const paxCost = parseFloat(selectedPax.getAttribute('data-cost')) || 0;
            selectedDetails.push(`${paxText} Package: ₱${paxCost.toLocaleString()}`);
            totalCost += paxCost;
        }

        const selectedCheckboxes = activeOptionsContainer.querySelectorAll('input[type="checkbox"]:checked');
        selectedCheckboxes.forEach(checkbox => {
            const optionName = checkbox.nextElementSibling ? checkbox.nextElementSibling.textContent : 'Option';
            const optionCost = parseFloat(checkbox.getAttribute('data-cost')) || 0;
            selectedDetails.push(`${optionName}: ₱${optionCost.toLocaleString()}`);
            totalCost += optionCost;
        });
    }

    const detailsContainer = document.getElementById('event_package');
    const costContainer = document.getElementById('cost');

    if (detailsContainer) {
        detailsContainer.innerHTML = selectedDetails.join('<br>'); 
    }
    if (costContainer) {
        costContainer.textContent = `₱${totalCost.toLocaleString()}`; 
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-group[id^="Other-"] input').forEach(input => {
        input.addEventListener('change', updateSelectedDetails);
    });

    updateSelectedDetails();
});

