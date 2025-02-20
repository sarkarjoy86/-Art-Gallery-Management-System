<?php
require '..\common\database.php';

// Fetch visitor data by ID
$id = $_GET['id'] ?? null;
if (!$id) {
    die('Invalid visitor ID.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['Name'];
    $phone = $_POST['Phone'];
    $email = $_POST['email'];

    $query = "UPDATE users SET Name = :Name, Phone = :Phone, email = :email WHERE Id = :Id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['Name' => $name, 'Phone' => $phone, 'email' => $email, 'Id' => $id]);

    header('Location: manage_visitors.php');
    exit;
}

$query = "SELECT * FROM users WHERE Id = :Id";
$stmt = $pdo->prepare($query);
$stmt->execute(['Id' => $id]);
$visitor = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Visitor</title>
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
            max-width: 500px; /* Smaller container width */
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

        /* Form Label Styling */
        .form-label {
            font-weight: bold;
            color: black; /* Make the label text black */
        }

        /* Form Control Styling */
        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
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
        <h2>Edit Visitor</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="Name" name="Name" value="<?= htmlspecialchars($visitor['Name']) ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="Phone" name="Phone" value="<?= htmlspecialchars($visitor['Phone']) ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($visitor['email']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Art Gallery Management. All rights reserved.</p>
    </footer>
</body>
</html>
