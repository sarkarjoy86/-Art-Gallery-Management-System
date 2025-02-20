<?php
// Include database connection
require_once '../common/database.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simple validation to check if email or password are empty
    if (empty($email) || empty($password)) {
        echo "Both fields are required!";
        exit;
    }

    // SQL query to fetch user with the given email
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simple password check (plaintext comparison)
        if ($password == $user['password']) {
            // Login successful, start session and redirect
            session_start();
            $_SESSION['user_id'] = $user['Id'];  // Store user id in session
            $_SESSION['email'] = $user['email'];  // Store email in session
            if($user["Type"]==1){
                header("Location: ../admin_dashboard.html");
            }
            else{
                echo "Redirecting to booking page..."; // Check if this is displayed
                header("Location: booking_page.php");
            }
            // Redirect to the booking page or dashboard
          
            exit;
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this email!";
    }
}
?>
