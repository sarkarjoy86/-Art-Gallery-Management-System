<?php
session_start();

// Destroy the session to log the admin out
session_unset();
session_destroy();

// Redirect to the login page or homepage
header("Location: ../visitor_login.html");
exit;
?>
