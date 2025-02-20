document.addEventListener('DOMContentLoaded', function () {
    const bookButtons = document.querySelectorAll('.btn-book'); // All "Book Now" buttons
    const exhibitionCards = document.querySelectorAll('.exhibition-card'); // Exhibition cards

    bookButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const exhibitionId = this.getAttribute('data-exhibition-id'); // Get the exhibition ID
            const visitorId = 1; // Assuming visitor ID is 1 (this would typically come from the session)

            // Example of submitting the booking data
            alert(`You have booked for exhibition ID: ${exhibitionId}`);
            // Here, you can send a POST request to your backend to record the booking in the database.
        });
    });
});
