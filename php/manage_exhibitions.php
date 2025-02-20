<?php
require_once '..\common\database.php';

// Fetch all exhibitions
$query = "SELECT * FROM exhibitions ORDER BY start_date DESC";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exhibitions</title>
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

        /* Add New Exhibition Button */
        .add-exhibition-btn {
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-align: center;
            display: block;
            width: 200px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .add-exhibition-btn:hover {
            background-color: #218838;
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
        <h2 class="text-center">Manage Exhibitions</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?= $row['ex_id'] ?></td>
                        <td><?= $row['title'] ?></td>
                        <td><?= $row['start_date'] ?></td>
                        <td><?= $row['end_date'] ?></td>
                        <td><?= $row['location'] ?></td>
                        <td>
                            <a href="edit_exhibition.php?ex_id=<?= $row['ex_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_exhibition.php?ex_id=<?= $row['ex_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Add New Exhibition Button below the container -->
    <a href="add_exhibition.php" class="add-exhibition-btn">Add New Exhibition</a>

    <footer>
        <p>&copy; 2025 Art Gallery Management. All rights reserved.</p>
    </footer>
</body>
</html>
