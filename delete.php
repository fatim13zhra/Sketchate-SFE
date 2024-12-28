<?php
session_start();
require 'dbconfig/config.php';

if (isset($_POST['id'])) {
    $recordId = $_POST['id'];

    // Delete the record from the "register" table
    $query = "DELETE FROM register WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $recordId);
    $stmt->execute();
}
?>
