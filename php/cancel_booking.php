<?php
// Include the database connection file
require '..\common\database.php';

// Check if a booking ID is passed
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Prepare the SQL query to delete the booking
    $sql = "DELETE FROM bookings WHERE booking_id = :booking_id";
    $stmt = $pdo->prepare($sql);

    // Bind the booking ID to the query
    $stmt->bindParam(':booking_id', $booking_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the manage booking page with a success message
        header("Location: manage_booking.php?status=success");
    } else {
        // Redirect back to the manage booking page with an error message
        header("Location: manage_booking.php?status=error");
    }
} else {
    // If no booking ID is provided, redirect with an error message
    header("Location: manage_booking.php?status=error");
}

?>
