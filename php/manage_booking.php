<?php
// Include the database connection file
require '..\common\database.php';

// Fetch booking information with associated user and exhibition details
$sql = "SELECT b.booking_id, b.users_id, b.exhibition_id, b.booking_date, u.name, u.email, e.title 
        FROM bookings b
        JOIN users u ON b.users_id = u.id
        JOIN exhibitions e ON b.exhibition_id = e.ex_id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Background Image and Blurry Effect */
        body {
            background: linear-gradient(to bottom right, #0056b3, #00bcd4); /* Gradient background */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Blurry Black Shade */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px); /* Apply the blur effect */
            z-index: -1;
        }

        /* Container Style */
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
            flex: 1; /* Allow content to grow */
        }

        h2 {
            color: #0056b3;
            font-weight: bold;
        }

        /* Table Styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0056b3;
            color: white;
        }

        .btn-danger {
            background-color: red;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: darkred;
        }

        footer {
            text-align: center;
            font-size: 14px;
            color: white; /* Change footer font color to white */
            padding: 10px;
            background-color: #333; /* Dark footer background */
            margin-top: auto; /* Ensure footer stays at the bottom */
            width: 100%;
        }

        /* Dashboard Button */
        .dashboard-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .dashboard-btn:hover {
            background-color: #004080;
        }
        .corner-logo {
      position: absolute;
      top: 10px;
      left: 10px;
      width: 120px; /* Adjust size as needed */
      height: auto;
      z-index: 3; /* Ensure it's above the background */
    }

    </style>
</head>
<body>
     <!-- Logo on the left corner -->
     <img src="images/logo1.png" alt="Logo" class="corner-logo" />
    <!-- Dashboard Button -->
    <a href="http://localhost:8080/AGMS/admin_dashboard.html" class="dashboard-btn">Dashboard</a>

    <div class="container">
        <h2 class="text-center">Manage Bookings</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Visitor Name</th>
                    <th>Email</th>
                    <th>Exhibition</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($bookings) {
                    foreach ($bookings as $row) { ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                            <td>
                                <a href="cancel_booking.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='6'>No bookings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Art Gallery Management. All rights reserved.</p>
    </footer>
</body>
</html>
