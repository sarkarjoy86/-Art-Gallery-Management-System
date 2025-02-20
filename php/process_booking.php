<?php
require '..\common\database.php';
session_start();

$bookingDetails = null; // Variable to store booking details

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exhibition_id = $_POST['exhibition_id'];
    $user_id = $_SESSION['user_id'] ?? null;

    if (!isset($_SESSION['user_id'])) {
        echo "Please log in to continue.";
        header('Refresh: 2; URL= http://localhost:8080/AGMS/php/booking_page.php');
        exit;
    }

    try {
        // Check if the booking already exists
        $checkSql = "SELECT COUNT(*) FROM bookings WHERE users_id = :user_id AND exhibition_id = :exhibition_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':user_id', $user_id);
        $checkStmt->bindParam(':exhibition_id', $exhibition_id);
        $checkStmt->execute();
        $existingBookingCount = $checkStmt->fetchColumn();

        if ($existingBookingCount > 0) {
            echo "<p class='alert alert-warning'>You have already booked this exhibition.</p>";
            header('Refresh: 2; URL= http://localhost:8080/AGMS/php/booking_page.php');
            exit;
        }

        // Insert booking data into the database
        $sql = "INSERT INTO bookings (booking_date, users_id, exhibition_id) VALUES (NOW(), :user_id, :exhibition_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':exhibition_id', $exhibition_id);
        
        if ($stmt->execute()) {
            $booking_id = $pdo->lastInsertId();

            // Fetch exhibition details
            $sql = "SELECT title, start_date, end_date FROM exhibitions WHERE ex_id = :exhibition_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':exhibition_id', $exhibition_id);
            $stmt->execute();
            $exhibition = $stmt->fetch(PDO::FETCH_ASSOC);

            // Store the booking details
            $bookingDetails = [
                'user_id' => $user_id,
                'booking_id' => $booking_id,
                'title' => htmlspecialchars($exhibition['title']),
                'start_date' => htmlspecialchars($exhibition['start_date']),
                'end_date' => htmlspecialchars($exhibition['end_date']),
            ];
        } else {
            echo "<p class='alert alert-danger'>Error occurred while booking. Please try again later.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='alert alert-warning'>Invalid request method.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url("images/art3.jpg") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures the body takes up the full height */
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7); /* Darker black shade */
            backdrop-filter: blur(8px);
            z-index: -1;
        }

        .container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%; /* Make the container a bit smaller */
            max-width: 600px;
        }

        h3 {
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
            color: black;  /* Change the font color to black */
        }

        ul li {
            margin-bottom: 10px;
        }

        .alert {
            font-size: 1.1rem;
            font-weight: bold;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <?php if ($bookingDetails) : ?>
            <div class="alert alert-success">
                Your exhibition has been successfully booked!
            </div>
            <h3>Booking Details</h3>
            <ul>
                <li><strong>User ID:</strong> <?= $bookingDetails['user_id'] ?></li>
                <li><strong>Booking ID:</strong> <?= $bookingDetails['booking_id'] ?></li>
                <li><strong>Exhibition:</strong> <?= $bookingDetails['title'] ?></li>
                <li><strong>Start Date:</strong> <?= $bookingDetails['start_date'] ?></li>
                <li><strong>End Date:</strong> <?= $bookingDetails['end_date'] ?></li>
            </ul>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; 2025 Art Gallery Management System. All rights reserved.</p>
    </footer>
</body>
</html>
