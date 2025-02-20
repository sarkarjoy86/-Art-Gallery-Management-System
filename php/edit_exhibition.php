<?php
require '..\common\database.php';

if (isset($_GET['ex_id'])) {
    $id = $_GET['ex_id'];
    $query = "SELECT * FROM exhibitions WHERE ex_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);  // Execute with the parameter
    $exhibition = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];

    $query = "UPDATE exhibitions SET title = ?, start_date = ?, end_date = ?, location = ? WHERE ex_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $start_date, $end_date, $location, $id]); // Pass parameters directly

    if ($stmt->execute()) {
        header("Location: manage_exhibitions.php");
        exit();
    } else {
        echo "Error updating exhibition.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exhibition</title>
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
            max-width: 800px; /* Larger container width */
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px 50px; /* Increased padding for better spacing */
            border-radius: 15px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 30px; /* Added margin for spacing */
            text-align: center; /* Centered title */
        }

        /* Form Label Styling */
        .form-label {
            font-weight: bold;
            color: black; /* Make the label text black */
            margin-bottom: 8px; /* Added margin for spacing between label and input */
        }

        /* Form Control Styling */
        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: none;
            margin-bottom: 15px; /* Added margin for spacing between input fields */
            padding: 12px 15px;
            font-size: 16px; /* Slightly larger font size for readability */
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }

        /* Button Style (Centered) */
        .btn-primary {
            background-color: #0056b3;
            border: none;
            padding: 18px 40px; /* Increased padding for better spacing */
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            color: white; /* White text color */
            width: auto; /* Make the button width fit the text */
            margin-top: 30px; /* Added top margin for spacing */
            display: block; /* Display button as block */
            margin-left: auto;
            margin-right: auto; /* Center button horizontally */
        }

        .btn-primary:hover {
            background-color: #003f7f;
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Exhibition</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $exhibition['title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $exhibition['start_date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $exhibition['end_date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="<?= $exhibition['location'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Exhibition</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Art Gallery Management. All rights reserved.</p>
    </footer>
</body>
</html>
