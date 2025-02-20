<?php
require '../common/database.php';  // Database connection
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to continue.";
    header("refresh:2; url= http://localhost:8080/AGMS/php/booking_page.php"); // Redirect after 2 seconds
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch user bookings along with exhibition details
    $query = "SELECT 
                bookings.booking_id, 
                bookings.booking_date, 
                (SELECT exhibitions.title FROM exhibitions WHERE ex_id = bookings.exhibition_id) AS Title, 
                (SELECT exhibitions.start_date FROM exhibitions WHERE ex_id = bookings.exhibition_id) AS Starting_date, 
                (SELECT exhibitions.end_date FROM exhibitions WHERE ex_id = bookings.exhibition_id) AS Ending_date 
              FROM bookings 
              WHERE users_id = :user_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p class='alert alert-danger'>Error: " . $e->getMessage() . "</p>";
}

// Check for the status parameter in the URL
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
            text-align: center;
        }

        h2 {
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .btn-cancel {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-cancel:hover {
            background-color: #e60000;
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

        /* CSS for dynamic messages */
        .alert {
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Booked Exhibitions</h2>
        
        <!-- Display success or error messages -->
        <?php if ($status == 'success') : ?>
            <div class="alert alert-success">
                Booking canceled successfully!
            </div>
        <?php elseif ($status == 'error') : ?>
            <div class="alert alert-danger">
                Error occurred while canceling the booking. Please try again.
            </div>
        <?php endif; ?>

        <?php if (!empty($bookings)) : ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exhibition Title</th>
                        <th>Booking Date</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $index => $booking) : ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($booking['Title']) ?></td>
                            <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                            <td><?= htmlspecialchars($booking['Starting_date']) ?></td>
                            <td><?= htmlspecialchars($booking['Ending_date']) ?></td>
                            <td>
                                <a href="cancel_booking_visitor.php?id=<?= $booking['booking_id'] ?>" class="btn-cancel">Cancel Booking</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="alert alert-info">No bookings found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Art Gallery Management System. All rights reserved.</p>
    </footer>
</body>
</html>
