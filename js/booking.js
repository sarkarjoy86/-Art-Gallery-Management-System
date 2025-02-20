// Function to handle form submission with AJAX
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const messageContainer = document.querySelector('.container');
    
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission
        
        // Get the exhibition_id from the form
        const exhibitionId = form.querySelector('input[name="exhibition_id"]').value;

        // Validate that exhibitionId is present
        if (!exhibitionId) {
            alert("Exhibition ID is missing.");
            return;
        }

        // Show a loading message while processing the request
        messageContainer.innerHTML = "<p>Processing your booking...</p>";

        // Create a FormData object to send the form data via AJAX
        const formData = new FormData();
        formData.append('exhibition_id', exhibitionId);

        // Send the form data via AJAX (POST request)
        fetch('book_exhibition.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            // Check if the response contains the success message
            if (data.includes('Booking successful')) {
                messageContainer.innerHTML = `<div class="message success">${data}</div>`;
            } else {
                messageContainer.innerHTML = `<div class="message error">${data}</div>`;
            }
        })
        .catch(error => {
            // Handle any errors during the AJAX request
            console.error('Error:', error);
            messageContainer.innerHTML = "<div class='message error'>An error occurred while processing your booking. Please try again later.</div>";
        });
    });
});
