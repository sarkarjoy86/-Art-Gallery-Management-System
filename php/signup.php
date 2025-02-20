<?php
// Include the database connection file
require_once '../common/database.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data including phone number
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']); // Added phone number

    // Simple validation: check if fields are empty
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($phone)) {
        echo "All fields are required!";
        exit;
    }

    // Validate phone number (must be exactly 11 digits)
    if (!preg_match('/^\d{11}$/', $phone)) {
        echo "Phone number must be exactly 11 digits!";
        exit;
    }

    // Validate email format (must end with @gmail.com)
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        echo "Email must be a valid Gmail address (ending with @gmail.com)!";
        exit;
    }

    // Validate password (must be exactly 6 digits)
    if (!preg_match('/^.{6,}$/', $password)) {
        echo "Password must be at least 6 characters!";
        exit;
    }
    // Check if user already exists in the database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "User with this email already exists!";
        exit;
    }

    // Concatenate first name and last name to form the full name
    $name = $first_name . ' ' . $last_name;

    // SQL query to insert the new user data including phone number
    $query = "INSERT INTO users (Name, email, password, Type, Phone) 
              VALUES (:name, :email, :password, :type, :phone)";  

    // Assuming the Type is 'visitor' for now. You can adjust it as per your need.
    $type = 2; // 2 for visitor

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':phone', $phone);

    // Execute the query and check if the user was inserted
    if ($stmt->execute()) {
        echo "Signup successful! You can now log in.";
        header("Location: ../visitor_login.html");
        exit;
    } else {
        echo "Something went wrong. Please try again!";
    }
}
?>
