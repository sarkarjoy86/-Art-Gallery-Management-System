document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form'); // Select the form
    const usernameInput = document.getElementById('username'); // Get username input
    const passwordInput = document.getElementById('password'); // Get password input

    form.addEventListener('submit', function (e) {
        // Validate username and password
        if (usernameInput.value === '' || passwordInput.value === '') {
            e.preventDefault(); // Prevent form submission
            alert('Please enter both username and password.');
        }
    });
});
