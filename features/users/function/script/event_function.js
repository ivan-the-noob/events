
                                        
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

                const otherOption = document.createElement('option');
                otherOption.value = "other";
                otherOption.setAttribute('data-cost', "0");
                otherOption.textContent = "Other";
                packageSelect.appendChild(otherOption);
            }
        };
        xhr.send('event_type=' + encodeURIComponent(selectedEventType));
    });

    document.getElementById('event-package').addEventListener('change', function () {
        const selectedOption = this.selectedOptions[0];
        const selectedValue = selectedOption.value;

        console.log("Selected Package Value:", selectedValue);

        const eventType = document.getElementById('event-type').value; 

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
                    console.log("Response: ", response); 

                    if (response) {
                        const paxOptions = response.split(';'); 

                        paxOptions.forEach(option => {
                            if (option) {
                                const packageDetails = option.split(','); 

                                if (packageDetails.length === 2) {
                                    const paxType = packageDetails[0].trim();
                                    const cost = packageDetails[1].trim();

                                
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

    function fetchExtraOptions(eventType) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/php/fetch_extra_options.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim();
                const extraOptionsContainer = document.getElementById('extra-options-container');
    
                extraOptionsContainer.innerHTML = '';
    
                if (response) {
                    const extraOptions = response.split(';');
    
                    extraOptions.forEach(option => {
                        if (option) {
                            const optionDetails = option.split(',');
                            if (optionDetails.length === 2) {
                                const extraName = optionDetails[0].trim();
                                const price = optionDetails[1].trim();
    
                                const div = document.createElement('div');
                                div.classList.add('form-check');
    
                                const input = document.createElement('input');
                                input.type = 'checkbox';
                                input.classList.add('form-check-input');
                                input.name = 'event_options[]'; 
                                input.value = extraName; 
                                input.setAttribute('data-cost', price);  
    
                                const label = document.createElement('label');
                                label.classList.add('form-check-label');
                                label.textContent = `${extraName}`; 
    
                                div.appendChild(input);
                                div.appendChild(label);
                                extraOptionsContainer.appendChild(div);
                            }
                        }
                    });
                } else {
                    extraOptionsContainer.innerHTML = '<p>No extra options available for this package.</p>';
                }
            }
        };
        xhr.send('type_of_event=' + encodeURIComponent(eventType)); 
    }


    document.addEventListener('change', function(event) {
        if (event.target && event.target.type === 'checkbox' && event.target.name === 'extra_options[]') {
            const selectedCheckbox = event.target;
            const dataCost = selectedCheckbox.getAttribute('data-cost'); 
            console.log('Selected Extra Option Cost: ' + dataCost); 
        }
    });

