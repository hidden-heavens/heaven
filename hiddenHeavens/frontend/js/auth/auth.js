console.log('auth.js loaded again');

document.querySelector('#loginForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('php/auth/login.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json()) // Parse response as JSON
        .then(data => {
            if (data.status === 'success') {
                window.location.href = data.redirect; // Redirect on success
            } else {
                document.querySelector('#loginError').textContent = data.message; // Display error
            }
        })
        .catch(error => {
            document.querySelector('#loginError').textContent = 'An error occurred. Please try again.';
            console.error(error);
        });
});



document.querySelector('#registerForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);
    const registerButton = document.querySelector('#registerButton');
    const loadingSpinner = document.querySelector('#loadingSpinner');
    const messageElement = document.querySelector('#registerMessage');

    // Disable the button and show the spinner
    registerButton.disabled = true;
    loadingSpinner.classList.remove('d-none');

    fetch('php/auth/register.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            // Handle success or error response
            if (data.status === 'success') {
                messageElement.textContent = data.message;
                messageElement.classList.remove('text-danger');
                messageElement.classList.add('text-success');
                this.reset(); // Clear the form
            } else {
                messageElement.textContent = data.message;
                messageElement.classList.remove('text-success');
                messageElement.classList.add('text-danger');
            }
        })
        .catch(error => {
            messageElement.textContent = 'An error occurred. Please try again.';
            messageElement.classList.remove('text-success');
            messageElement.classList.add('text-danger');
            console.error(error);
        })
        .finally(() => {
            // Re-enable the button and hide the spinner
            registerButton.disabled = false;
            loadingSpinner.classList.add('d-none');
        });
});




document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    if (togglePassword) {
        togglePassword.addEventListener("click", function () {
            const passwordInput = document.getElementById("passwordInput");
            if (passwordInput) {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            } else {
                console.error("Password input not found.");
            }
        });
    } else {
        console.error("Toggle button not found.");
    }
});


  document.querySelector('#changePasswordForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('php/user/change-password.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            const messageElement = document.querySelector('#passwordChangeMessage');
            if (data.status === 'success') {
                messageElement.textContent = data.message;
                messageElement.classList.remove('text-danger');
                messageElement.classList.add('text-success');
                this.reset(); // Reset the form
            } else {
                messageElement.textContent = data.message;
                messageElement.classList.remove('text-success');
                messageElement.classList.add('text-danger');
            }
        })
        .catch(error => {
            document.querySelector('#passwordChangeMessage').textContent = 'An error occurred. Please try again.';
            console.error(error);
        });
});
