document.getElementById('event-type').addEventListener('change', function() {
    const selectedOption = this.selectedOptions[0];
    const selectedEventType = selectedOption.value;

    console.log("Selected Event Type: ", selectedEventType);

    const packageOptionsDiv = document.getElementById('event-package-options');
    if (packageOptionsDiv) {
        packageOptionsDiv.style.display = 'block';
    }

    const packageSelect = document.getElementById('event-package');
    if (packageSelect) {
        packageSelect.innerHTML = '<option value="" disabled selected>Select a package</option>';
    }

    // Fetch event packages based on selected event type
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../function/php/fetch_event_packages.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            console.log("Fetched Data (Event Packages): ", response);

            if (response) {
                const packages = response.split(';');
                packages.forEach(function (packageData) {
                    if (packageData) {
                        const packageDetails = packageData.split(',');
                        const description = packageDetails[0].trim();
                        const price = packageDetails[1].trim();

                        const option = document.createElement('option');
                        option.value = description;
                        option.setAttribute('data-cost', price);
                        option.textContent = description;
                        packageSelect.appendChild(option);
                    }
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.disabled = true;
                option.textContent = 'No packages available for this event type';
                packageSelect.appendChild(option);
            }

            // Add "Other" option to the select dropdown
            const otherOption = document.createElement('option');
            otherOption.value = "other";
            otherOption.setAttribute('data-cost', "0");
            otherOption.textContent = "Other";
            packageSelect.appendChild(otherOption);

            resetCustomPackageOptions();  // Reset any custom package inputs
        }
    };
    xhr.send('event_type=' + encodeURIComponent(selectedEventType));

    // Fetch dishes for the selected event type (beef, pork, chicken, pasta, dessert, fish, drinks)
    fetchDishes('beef');     // Fetch for 'beef'
    fetchDishes('pork');     // Fetch for 'pork'
    fetchDishes('chicken');  // Fetch for 'chicken'
    fetchDishes('pasta');    // Fetch for 'pasta'
    fetchDishes('dessert');  // Fetch for 'dessert'
    fetchDishes('fish');     // Fetch for 'fish'
    fetchDishes('drinks');   // Fetch for 'drinks'
});

document.getElementById('event-package').addEventListener('change', function() {
    const selectedPackage = this.value;
    const totalPaymentElement = document.getElementById('cost');
    let newCost = 0;

    console.log("Selected Package: ", selectedPackage);

    // If the selected package is "other", reset the cost
    if (selectedPackage === "other") {
        totalPaymentElement.textContent = '₱0';
        showCustomPackageInput();
        showCustomPackageOptions();
    } else {
        const selectedOption = this.selectedOptions[0];
        const cost = selectedOption.getAttribute('data-cost');
        totalPaymentElement.textContent = '₱' + parseInt(cost).toLocaleString('en-US');
        hideCustomPackageInput();
        hideCustomPackageOptions();
    }

    // Show the "Choose Your Dish" section after selecting an event package
    const beefOptionsDiv = document.getElementById('beef-options');
    const porkOptionsDiv = document.getElementById('pork-options');
    const chickenOptionsDiv = document.getElementById('chicken-options');
    const pastaOptionsDiv = document.getElementById('pasta-options');
    const dessertOptionsDiv = document.getElementById('dessert-options');
    const fishOptionsDiv = document.getElementById('fish-options');
    const drinksOptionsDiv = document.getElementById('drinks-options');

    if (beefOptionsDiv && porkOptionsDiv && chickenOptionsDiv && pastaOptionsDiv && dessertOptionsDiv && fishOptionsDiv && drinksOptionsDiv) {
        beefOptionsDiv.style.display = 'block';   // Show beef dish selection
        porkOptionsDiv.style.display = 'block';   // Show pork dish selection
        chickenOptionsDiv.style.display = 'block'; // Show chicken dish selection
        pastaOptionsDiv.style.display = 'block';  // Show pasta dish selection
        dessertOptionsDiv.style.display = 'block'; // Show dessert dish selection
        fishOptionsDiv.style.display = 'block';    // Show fish dish selection
        drinksOptionsDiv.style.display = 'block';  // Show drinks dish selection
    }

    // Fetch dishes for all categories: 'beef', 'pork', 'chicken', 'pasta', 'dessert', 'fish', 'drinks'
    fetchDishes('beef');
    fetchDishes('pork');
    fetchDishes('chicken');
    fetchDishes('pasta');
    fetchDishes('dessert');
    fetchDishes('fish');
    fetchDishes('drinks');
});

// Function to fetch dishes for a given category (e.g., 'beef', 'pork', 'chicken', 'pasta', 'dessert', 'fish', 'drinks')
function fetchDishes(category) {
    const dishSelect = document.getElementById(category + '-select');
    dishSelect.innerHTML = '<option value="" disabled selected>Select a dish</option>';  // Reset dish options

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../function/php/fetch_dishes.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText.trim();
            console.log("Fetched Data (Dishes for " + category + "): ", response);

            if (response) {
                const dishes = response.split(';');
                dishes.forEach(function (dishName) {
                    if (dishName) {
                        const option = document.createElement('option');
                        option.value = dishName;
                        option.textContent = dishName;
                        dishSelect.appendChild(option);
                    }
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.disabled = true;
                option.textContent = 'No dishes available';
                dishSelect.appendChild(option);
            }
        }
    };
    xhr.send('category=' + category);  // Send category dynamically (either 'beef', 'pork', 'chicken', 'pasta', 'dessert', 'fish', or 'drinks')
}





function showCustomPackageInput() {
    const customPackageInputDiv = document.getElementById('custom-package-input');
    if (customPackageInputDiv) {
        customPackageInputDiv.style.display = 'block';
    }
}

function hideCustomPackageInput() {
    const customPackageInputDiv = document.getElementById('custom-package-input');
    if (customPackageInputDiv) {
        customPackageInputDiv.style.display = 'none';
    }
}

function showCustomPackageOptions() {
    const customPackageOptionsDiv = document.querySelector('.custom-package-options');
    if (customPackageOptionsDiv) {
        customPackageOptionsDiv.style.display = 'block';
    }
}

function hideCustomPackageOptions() {
    const customPackageOptionsDiv = document.querySelector('.custom-package-options');
    if (customPackageOptionsDiv) {
        customPackageOptionsDiv.style.display = 'none';
    }

    const extraOptionsContainer = document.getElementById('extra-options-container');
    if (extraOptionsContainer) {
        extraOptionsContainer.innerHTML = '';
    }
}

function resetCustomPackageOptions() {
    hideCustomPackageOptions();
    hideCustomPackageInput();
}




document.addEventListener('DOMContentLoaded', function () {
    const eventTypeSelect = document.getElementById('event-type');
    const eventTypeParagraph = document.getElementById('event_type');
    const eventPackageSelect = document.getElementById('event-package');
    const eventPackageParagraph = document.getElementById('event_package');
    const totalPaymentElement = document.getElementById('cost');

    let totalPayment = 0;   

    if (eventTypeSelect && eventTypeParagraph) {
        eventTypeParagraph.textContent = eventTypeSelect.value;
        
        eventTypeSelect.addEventListener('change', function () {
            const selectedEventType = this.value;
            eventTypeParagraph.textContent = selectedEventType; 
            console.log("Selected Event Type: ", selectedEventType);
        });
    }

    if (eventPackageSelect && eventPackageParagraph) {
        eventPackageSelect.addEventListener('change', function () {
            const selectedOption = this.selectedOptions[0];
            const selectedValue = selectedOption.value;
            const dataCost = selectedOption.getAttribute('data-cost') || '0';

            totalPayment = 0;  
            
            eventPackageParagraph.textContent = `${selectedValue} - ₱${parseInt(dataCost).toLocaleString('en-US')}`;

            console.log(`Selected Package: ${selectedValue}, Cost: ₱${dataCost}`);

            updateTotalPayment(parseInt(dataCost));
        });
    }

    eventPackageSelect.addEventListener('change', function () {
        const selectedOption = this.selectedOptions[0];
        const selectedValue = selectedOption.value;

        console.log("Selected Package Value:", selectedValue);

        const eventType = document.getElementById('event-type').value;

        resetExtraOptions();

        if (selectedValue === "other") {
            console.log("Selected Event Type:", eventType);

            const customPackageOptionsDiv = document.querySelector('.custom-package-options');
            customPackageOptionsDiv.style.display = 'block';
            const formGroup = customPackageOptionsDiv.querySelector('.form-check-group');

            formGroup.innerHTML = '';
            console.log("Cleared form group inner HTML");

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../function/php/fetch_pax_options.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    console.log("Response from fetch_pax_options.php:", response);

                    if (response) {
                        const paxOptions = response.split(';');
                        console.log("Pax Options Array:", paxOptions);

                        paxOptions.forEach(option => {
                            if (option) {
                                const packageDetails = option.split(',');

                                if (packageDetails.length === 2) {
                                    const paxType = packageDetails[0].trim();
                                    const cost = packageDetails[1].trim();

                                    console.log(`Pax Type: ${paxType}, Cost: ₱${cost}`);

                                    const input = document.createElement('input');
                                    input.type = 'radio';
                                    input.classList.add('form-check-input');
                                    input.name = 'event_options[]';
                                    input.value = paxType;
                                    input.setAttribute('data-cost', cost);

                                    const label = document.createElement('label');
                                    label.classList.add('form-check-label');
                                    label.textContent = `${paxType}`;

                                    const div = document.createElement('div');
                                    div.classList.add('form-check');
                                    div.appendChild(input);
                                    div.appendChild(label);

                                    formGroup.appendChild(div);

                                  
                                    input.addEventListener('change', function () {
                                        uncheckAllCheckboxes();
                                    
                                        const selectedRadio = this;
                                        const paxType = selectedRadio.value;
                                        const cost = selectedRadio.getAttribute('data-cost');
                                    
                                        console.log(`Selected Pax Type: ${paxType}, Cost: ₱${cost}`);
                                    
                                        updateEventPackageParagraph(paxType, cost);
                                    
                                        totalPayment = 0; 
                                        updateTotalPayment(parseInt(cost));

                                        adjustGlazingTableCost(paxType);
                                        adjustCateringCost(paxType);
                                    });
                                }
                            }
                        });
                    } else {
                        formGroup.innerHTML = '<p>No options available for the selected event type.</p>';
                    }
                }
            };

            xhr.send('type_of_event=' + encodeURIComponent(eventType));
        } else {
            document.querySelector('.custom-package-options').style.display = 'none';
            console.log("Hiding custom package options");
        }

        fetchExtraOptions(eventType);
    });

    function adjustGlazingTableCost(paxType) {
        const glazingTableCheckbox = document.querySelector('input[name="event_options[]"][value="Glazing Table"]');
        
        if (glazingTableCheckbox) {
            let newCost = 6000; 
            switch (paxType) {
                case '50 Pax Package':
                    newCost = 6000;
                    break;
                case '60 Pax Package':
                    newCost = 7000;
                    break;
                case '80 Pax Package':
                    newCost = 10000;
                    break;
                case '100 Pax Package':
                    newCost = 13000;
                    break;
                case '150 Pax Package':
                    newCost = 17000;
                    break;
                case '200 Pax Package':
                    newCost = 25000;
                    break;
                default:
                    newCost = 6000;
                    break;
            }
    
            glazingTableCheckbox.setAttribute('data-cost', newCost);
    
            const label = glazingTableCheckbox.nextElementSibling;
            if (label) {
                label.textContent = "Glazing Table";
            }
            
            console.log(`Updated Glazing Table cost to ₱${newCost.toLocaleString('en-US')}`);
        }
    }
    function adjustCateringCost(paxType) {
        const cateringCheckbox = document.querySelector('input[name="event_options[]"][value="Catering"]');
        
        if (cateringCheckbox) {
            let newCost = 13000;
    
            switch (paxType) {
                case '50 Pax Package':
                    newCost = 13000;
                    break;
                case '60 Pax Package':
                    newCost = 16000;
                    break;
                case '80 Pax Package':
                    newCost = 19000;
                    break;
                case '100 Pax Package':
                    newCost = 22000;
                    break;
                case '150 Pax Package':
                    newCost = 26000;
                    break;
                case '200 Pax Package':
                    newCost = 35000;
                    break;
                default:
                    newCost = 13000; 
                    break;
            }
    
            cateringCheckbox.setAttribute('data-cost', newCost);
    
            const label = cateringCheckbox.nextElementSibling;
            if (label) {
                label.textContent = "Catering";
            }
    
            console.log(`Updated Catering cost to ₱${newCost.toLocaleString('en-US')}`);
        }
    }

    function uncheckAllCheckboxes() {
        const checkboxes = document.querySelectorAll('#extra-options-container .form-check-input');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        console.log("Unchecking all checkboxes.");
    }

    function resetExtraOptions() {
        uncheckAllCheckboxes();
    
        const extraOptionsContainer = document.getElementById('extra-options-container');
        extraOptionsContainer.innerHTML = '';  
        console.log("Cleared extra options.");
    }

    function fetchExtraOptions(eventType) {
        console.log("Fetching extra options for event type:", eventType);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/php/fetch_extra_options.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim();
                console.log("Response from fetch_extra_options.php:", response);

                const extraOptionsContainer = document.getElementById('extra-options-container');
                extraOptionsContainer.innerHTML = '';

                if (response) {
                    const extraOptions = response.split(';');
                    console.log("Extra Options Array:", extraOptions);

                    extraOptions.forEach(option => {
                        if (option) {
                            const optionDetails = option.split(',');
                            if (optionDetails.length === 2) {
                                const extraName = optionDetails[0].trim();
                                const price = optionDetails[1].trim();

                                console.log(`Extra Name: ${extraName}, Price: ₱${price}`);

                                const div = document.createElement('div');
                                div.classList.add('form-check');

                                const input = document.createElement('input');
                                input.type = 'checkbox';
                                input.classList.add('form-check-input');
                                input.name = 'event_options[]';
                                input.value = extraName;
                                input.setAttribute('data-cost', price);
                                input.setAttribute('data-id', extraName + '-' + price); 

                                const label = document.createElement('label');
                                label.classList.add('form-check-label');
                                label.textContent = `${extraName}`;

                                div.appendChild(input);
                                div.appendChild(label);
                                extraOptionsContainer.appendChild(div);

                                input.addEventListener('change', function () {
                                    const selectedCheckbox = this;
                                    const extraName = selectedCheckbox.value;
                                    const dataCost = selectedCheckbox.getAttribute('data-cost');
                                    const dataId = selectedCheckbox.getAttribute('data-id');

                                    const eventPackageParagraph = document.getElementById('event_package');

                                    if (selectedCheckbox.checked) {
                                        console.log(`Checkbox selected - Extra Option: ${extraName}, Cost: ₱${dataCost}`); 
                
                                        if (!eventPackageParagraph.querySelector(`[data-id="${dataId}"]`)) {
                                            const div = document.createElement('div');
                                            div.classList.add('d-flex', 'justify-content-between');
                                            div.setAttribute('data-id', dataId);

                                            const pName = document.createElement('p');
                                            pName.classList.add('mb-0');
                                            pName.textContent = extraName;

                                            const pCost = document.createElement('p');
                                            pCost.classList.add('mb-0');
                                            pCost.textContent = '₱' + parseInt(dataCost).toLocaleString('en-US');

                                            div.appendChild(pName);
                                            div.appendChild(pCost);
                                            eventPackageParagraph.appendChild(div);
                                        }

                                        updateTotalPayment(parseInt(dataCost));
                                    } else {
                                        console.log(`Checkbox deselected - Extra Option: ${extraName}, Cost: ₱${dataCost}`);
                                   
                                        const extraDiv = eventPackageParagraph.querySelector(`[data-id="${dataId}"]`);
                                        if (extraDiv) {
                                            extraDiv.remove();
                                        }

                                       
                                        updateTotalPayment(-parseInt(dataCost));
                                    }
                                });
                            }
                        }
                    });
                } else {
                    extraOptionsContainer.innerHTML = '<p>No extra options available.</p>';
                }
            }
        };

        xhr.send('type_of_event=' + encodeURIComponent(eventType));
    }

    function updateEventPackageParagraph(option, cost) {
        const eventPackageParagraph = document.getElementById('event_package');
        eventPackageParagraph.innerHTML = `
            <div class="d-flex justify-content-between" style="gap: 120px;">
                <p class="mb-2">${option}</p>
                <p class="mb-2">₱${parseInt(cost).toLocaleString('en-US')}</p>
            </div>
        `;
    }
    

    function updateTotalPayment(amount) {
        totalPayment += amount;
    
        totalPaymentElement.textContent = '₱' + totalPayment.toLocaleString('en-US');
        
        const eventCostInput = document.getElementById('event-cost');
        if (eventCostInput) {
            eventCostInput.value = totalPayment;
        }
    
        console.log("Total Payment (Visible): " + totalPaymentElement.textContent);
        console.log("Event Cost (Hidden Input): " + eventCostInput.value);
    }
    
});
