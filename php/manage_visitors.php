<?php
require '..\common\database.php';

// Fetch visitor records from the database (removed password)
$query = "SELECT Id, Name, Phone, email FROM users WHERE Type = 2"; // Removed password from query
$stmt = $pdo->query($query);
$visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Visitors</title>
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
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            flex-direction: column;
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
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
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

        /* Footer */
        footer {
            text-align: center;
            font-size: 14px;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px;
            background-color: #333;
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

    <div class="container mt-5">
        <h2 class="text-center">Manage Visitors</h2>

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitors as $visitor): ?>
                    <tr>
                        <td><?= htmlspecialchars($visitor['Id']) ?></td>
                        <td><?= htmlspecialchars($visitor['Name']) ?></td>
                        <td><?= htmlspecialchars($visitor['Phone']) ?></td>
                        <td><?= htmlspecialchars($visitor['email']) ?></td>
                        <td>
                            <a href="edit_visitor.php?id=<?= urlencode($visitor['Id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_visitor.php?id=<?= urlencode($visitor['Id']) ?>" class="btn btn-danger btn-sm delete-btn">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2025 Art Gallery Management. All rights reserved.</p>
    </footer>

    <script src="js/manage_visitors.js"></script>
</body>
</html>
