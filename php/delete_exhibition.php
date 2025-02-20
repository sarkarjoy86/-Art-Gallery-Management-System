<?php
require '..\common\database.php';

if (isset($_GET['ex_id'])) {
    $id = $_GET['ex_id'];
    $query = "DELETE FROM exhibitions WHERE ex_id = ?";
    $stmt = $pdo->prepare($query);
    
    // Execute with the parameter directly
    if ($stmt->execute([$id])) {
        header("Location: manage_exhibitions.php");
        exit();
    } else {
        echo "Error deleting exhibition.";
    }
}
?>
