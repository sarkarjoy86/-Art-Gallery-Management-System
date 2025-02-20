<?php
// Include the database connection file
require_once '../common/database.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Simple validation: check if fields are empty
    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        echo "All fields are required!";
        exit;
    }

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Check if email exists in the database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "No user found with this email address!";
        exit;
    }

    // Hash the new password before storing it
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // SQL query to update the password in the database
    $query = "UPDATE users SET password = :password WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);

    // Execute the query and check if the password was updated
    if ($stmt->execute()) {
        echo "Password reset successfully!";
        // Redirect to login page or show success message
        header("Location: ../visitor_login.html");
        exit;
    } else {
        echo "Something went wrong. Please try again!";
    }
}
?>

<!-- HTML Form for password reset -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Body Styling */
        body {
            background: linear-gradient(to bottom right, #0056b3, #00bcd4); /* Gradient background */
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height */
            position: relative;
        }

        /* Backdrop blur effect */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            z-index: 1;
        }

        /* Container Styling (Password Reset Box) */
        .container {
            position: relative;
            z-index: 2;
            max-width: 400px; /* Set a max width */
            width: 90%; /* Make it responsive */
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            color: #0056b3;
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        /* Ensure Labels Are Black */
        .form-label {
            color: black !important; /* Force black color */
            font-weight: bold;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.8);
            color: black; /* Ensure text inside input is black */
        }

        .form-group input:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 8px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        button,
        .btn {
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            width: 100%;
            margin-top: 15px;
        }

        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #5a0fb8, #2068dc);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Footer Styling */
        footer {
            padding: 10px 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            z-index: 3; /* Ensure the footer is above the background */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="forget_password.php" class="mt-4">
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>

    <footer class="text-center">
        <p>&copy; 2025 Art Gallery Management. All rights reserved.</p>
    </footer>

</body>
</html>
