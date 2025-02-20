document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form'); // Select the form
    const firstNameInput = document.getElementById('first_name'); // Get first name input
    const lastNameInput = document.getElementById('last_name'); // Get last name input
    const emailInput = document.getElementById('email'); // Get email input
    const passwordInput = document.getElementById('password'); // Get password input

    form.addEventListener('submit', function (e) {
        // Validate all fields
        if (firstNameInput.value === '' || lastNameInput.value === '' || emailInput.value === '' || passwordInput.value === '') {
            e.preventDefault(); // Prevent form submission
            alert('Please fill out all fields.');
        }
    });
});
