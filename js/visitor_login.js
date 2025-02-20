document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form'); // Select the form
    const emailInput = document.getElementById('email'); // Get email input
    const passwordInput = document.getElementById('password'); // Get password input

    form.addEventListener('submit', function (e) {
        // Validate email and password
        if (emailInput.value === '' || passwordInput.value === '') {
            e.preventDefault(); // Prevent form submission
            alert('Please enter both email and password.');
        }
    });
});
