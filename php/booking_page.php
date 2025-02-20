<?php
// Include the database connection file
require '..\common\database.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the exhibition ID from the form
    $exhibition_id = $_POST['exhibition_id'];

    // Get the user ID from the session (assuming the user is logged in)
    session_start(); // Start session if not already started
    $user_id = $_SESSION['user_id']; // Replace with the actual session variable for the logged-in user

    // Prepare the SQL query to insert the booking
    $sql = "INSERT INTO bookings (user_id, exhibition_id) VALUES (:user_id, :exhibition_id)";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters and execute the query
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':exhibition_id', $exhibition_id);

    if ($stmt->execute()) {
        // Fetch the inserted booking details (for confirmation message)
        $booking_id = $pdo->lastInsertId();
        $sql = "SELECT title, start_date, end_date FROM exhibitions WHERE ex_id = :exhibition_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':exhibition_id', $exhibition_id);
        $stmt->execute();
        $exhibition = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Display the success message and booking details
        echo "<p class='message success'>Your exhibition has been booked!</p>";
        echo "<p>Booking Details:</p>";
        echo "<ul>";
        echo "<li><strong>User ID:</strong> $user_id</li>";
        echo "<li><strong>Booking ID:</strong> $booking_id</li>";
        echo "<li><strong>Exhibition:</strong> " . htmlspecialchars($exhibition['title']) . "</li>";
        echo "<li><strong>Start Date:</strong> " . htmlspecialchars($exhibition['start_date']) . "</li>";
        echo "<li><strong>End Date:</strong> " . htmlspecialchars($exhibition['end_date']) . "</li>";
        echo "</ul>";
    } else {
        echo "<p class='message error'>There was an error with the booking. Please try again.</p>";
    }
} else {
    // Fetch the exhibitions from the database
    $sql = "SELECT ex_id, title, location, start_date, end_date FROM exhibitions";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $exhibitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book Exhibition</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
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

        .button-container {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .logout-btn {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .logout-btn:hover {
            background: #e60000;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        .bookings-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .bookings-btn:hover {
            background: #0056b3;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        .container {
            max-width: 700px; /* Smaller container width */
            width: 90%;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px; /* Smaller padding */
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-top: 30px; /* Adjusted margin */
            margin-bottom: auto; /* Ensures the footer stays at the bottom */
        }

        h2 {
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .exhibition-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            color: black;
        }

        .exhibition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-book {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .btn-book:hover {
            background: linear-gradient(to right, #5a0fb8, #2068dc);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        footer {
            margin-top: auto; /* Pushes the footer to the bottom */
            font-size: 0.9rem;
            color: #ccc;
            text-align: center;
            padding: 10px;
            background: rgba(0, 0, 0, 0.7); /* Dark background for footer */
        }

        .message {
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        .message.success {
            background-color: #4CAF50;
            color: white;
        }

        .message.error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="booking_list.php">
            <button class="bookings-btn">Your Bookings</button>
        </a>

        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <h2>Available Exhibitions</h2>
        <?php if (!empty($exhibitions)) {
            foreach ($exhibitions as $row) { ?>
                <div class="exhibition-card">
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><strong>Start Date:</strong> <?php echo htmlspecialchars($row['start_date']); ?></p>
                    <p><strong>End Date:</strong> <?php echo htmlspecialchars($row['end_date']); ?></p>
                    <form method="POST" action="process_booking.php">
                        <input type="hidden" name="exhibition_id" value="<?php echo $row['ex_id']; ?>">
                        <button type="submit" class="btn-book">Book Now</button>
                    </form>
                </div>
        <?php }
        } else {
            echo "<p>No exhibitions available at the moment.</p>";
        } ?>
    </div>

    <footer>
        <p>&copy; 2025 Art Gallery Management System. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
$pdo = null;
?>
