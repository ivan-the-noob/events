<?php
session_start();
include '../../../db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMIEL| Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="row login-container">
                    <div class="col-md-5 login-left text-center">
                    <img src="../../../assets/logo.png" alt="Logo">
                    </div>
                    <div class="col-md-7 login-right">
                        <h5 class="mb-3">Sign Up</h5>
                        <form id="signupForm" method="POST" action="../function/authentication/update-status.php">
    <!-- Step 1: Personal Information -->
    <div id="step1">
        <div id="validationMessage1" class="mb-3 btn btn-danger" style="display: none;">
            <p class="text-center fw-bold">Please fill out all fields before proceeding.</p>
        </div>
        <div class="mb-3">
            <input type="text" name="first_name" class="form-control" placeholder="Enter your first name" required>
        </div>
        <div class="mb-3">
            <input type="text" name="last_name" class="form-control" placeholder="Enter your last name" required>
        </div>
        <div class="mb-3">
            <input type="text" name="address" class="form-control" placeholder="Enter your address" required>
        </div>
        <div class="mb-3">
            <input type="text" name="contact_number" class="form-control" placeholder="Enter your contact number" required>
        </div>
        <button type="button" class="btn btn-primary d-flex" style="margin-left: auto;" onclick="validateStep(1, 2)">Next</button>
    </div>

    <!-- Step 2: Account Credentials -->
    <div id="step2" style="display: none;">
        <div id="validationMessage2Fill" class="mb-3 btn btn-danger" style="display: none;">
            <p class="text-center fw-bold">Please fill out all fields.</p>
        </div>
        <div id="validationMessage2Match" class="mb-3 btn btn-danger" style="display: none;">
            <p class="text-center fw-bold">Password does not match.</p>
        </div>
        <div id="validationMessage2Strength" class="mb-3 btn btn-danger" style="display: none;">
            <p class="text-center fw-bold">Password must contain symbols and numbers (e.g., @Amiel12).</p>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
        </div>
        <button type="button" class="btn btn-secondary" onclick="showStep(1)">Back</button>
        <button type="button" class="btn btn-primary" onclick="validateStep2()">Next</button>
    </div>

    <!-- Step 3: Verification Code -->
        <div id="step3" style="display: none;">
        <div id="validationMessageVerification" class="mb-3 btn btn-danger" style="display: none;">
            <p class="text-center fw-bold">Incorrect verification code.</p>
        </div>
        <div class="mb-3">
            <input type="text" name="verification_code" class="form-control" placeholder="Enter 4-digit code" required>
        </div>
        <button type="button" class="btn btn-secondary" onclick="showStep(2)">Back</button>
        <button type="button" class="btn btn-primary" onclick="validateStep3(event)">Verify</button>
    </div>

    <!-- Step 4: Accept Terms and Complete Sign-up -->
    <div id="step4" style="display: none;">
        <div id="validationMessage4" class="mb-3 btn btn-danger" style="display: none;">
            <p class="text-center fw-bold">You must accept the terms and conditions to sign up.</p>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="accept_terms" class="form-check-input" id="acceptTerms" required>
            <label class="form-check-label" for="acceptTerms">Accept Terms and Conditions</label>
        </div>
        <button type="button" class="btn btn-secondary" onclick="showStep(3)">Back</button>
        <button type="submit" class="btn btn-success w-50">Sign Up</button>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
function showStep(step) {
    console.log('Showing step:', step);  // Add this line for debugging

    // Hide all steps
    document.getElementById("step1").style.display = "none";
    document.getElementById("step2").style.display = "none";
    document.getElementById("step3").style.display = "none";
    document.getElementById("step4").style.display = "none";

    // Show the current step
    document.getElementById("step" + step).style.display = "block";

    // Hide validation messages
    document.getElementById("validationMessage1").style.display = "none";
    document.getElementById("validationMessage2Fill").style.display = "none";
    document.getElementById("validationMessage2Match").style.display = "none";
    document.getElementById("validationMessage2Strength").style.display = "none";
}

function validateStep(currentStep, nextStep) {
    const stepInputs = document.querySelectorAll(`#step${currentStep} input`);
    let valid = true;

    for (let input of stepInputs) {
        if (input.value.trim() === "") {
            valid = false;
            break;
        }
    }

    if (!valid) {
        document.getElementById(`validationMessage${currentStep}`).style.display = "block";
    } else {
        showStep(nextStep);
    }
}

function validateStep2() {
    const email = document.querySelector("#step2 input[name='email']").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("confirm_password").value.trim();
    const passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])/; // Password must contain a number and a symbol

    let valid = true;

    // Clear all validation messages first
    document.getElementById("validationMessage2Fill").style.display = "none";
    document.getElementById("validationMessage2Match").style.display = "none";
    document.getElementById("validationMessage2Strength").style.display = "none";

    if (email === "" || password === "" || confirmPassword === "") {
        document.getElementById("validationMessage2Fill").style.display = "block";
        valid = false;
    } else if (password !== confirmPassword) {
        document.getElementById("validationMessage2Match").style.display = "block";
        valid = false;
    } else if (!passwordRegex.test(password)) {
        document.getElementById("validationMessage2Strength").style.display = "block";
        valid = false;
    }

    if (valid) {
        // Now call the combined sign-up.php
        signUpUser(email, password);
    }
}

function signUpUser(email, password) {
    const firstName = document.querySelector("#step1 input[name='first_name']").value.trim();
    const lastName = document.querySelector("#step1 input[name='last_name']").value.trim();
    const address = document.querySelector("#step1 input[name='address']").value.trim();
    const contactNumber = document.querySelector("#step1 input[name='contact_number']").value.trim();

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../function/authentication/sign-up.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    const data = `first_name=${encodeURIComponent(firstName)}&last_name=${encodeURIComponent(lastName)}&address=${encodeURIComponent(address)}&contact_number=${encodeURIComponent(contactNumber)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(password)}`;

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = xhr.responseText;

            if (response === 'success') {
                showStep(3); // Move to the verification step
            } else {
                alert('Registration failed. Please try again.');
            }
        }
    };

    xhr.send(data);
}

function validateStep3(event) {
    const verificationCode = document.querySelector("#step3 input[name='verification_code']").value.trim();

    // Hide validation messages before checking conditions
    document.getElementById("validationMessageVerification").style.display = "none";

    // Check if verification code is empty
    if (verificationCode === "") {
        document.getElementById("validationMessageVerification").style.display = "block";
        event.preventDefault();  // Prevent form submission
    } else {
        console.log("Sending verification request to server...");

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../function/authentication/checkVerificationCode.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        const data = `verification_code=${encodeURIComponent(verificationCode)}&email=${encodeURIComponent(document.querySelector("input[name='email']").value)}`;

        // When the response is ready, handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText.trim();  // Ensure to trim the response to avoid extra whitespace
                console.log('Server Response:', response);  // Log the server response

                if (response === 'incorrect') {
                    document.getElementById("validationMessageVerification").style.display = "block";
                    event.preventDefault(); // Prevent further steps if incorrect
                } else if (response === 'correct') {
                    console.log('Verification code is correct. Proceeding to step 4.');
                    showStep(4);  // Proceed to Step 4 if the code is correct
                } else {
                    console.log("Unexpected response:", response);
                }
            }
        };

        // Send the request
        xhr.send(data);
    }
}






function acceptTermsAndSignUp() {
    const verificationCode = document.querySelector("#step3 input[name='verification_code']").value.trim();
    const acceptTerms = document.getElementById("acceptTerms").checked;

    if (acceptTerms) {
        // Submit the final registration
        document.getElementById("signupForm").submit();
    } else {
        alert("You must accept the terms to complete the registration.");
    }
}

</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
