<?php
require '..\common\database.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $query = "DELETE FROM users WHERE Id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
}

header('Location: manage_visitors.php');
exit;
?>
