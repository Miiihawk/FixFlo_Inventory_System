<?php
require_once 'db_connection.php';

function getAllUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT user_id, username, role, created_at, updated_at FROM users");
    $stmt->execute();
    return $stmt->fetchAll();
}

function deleteUser($userId) {
    global $pdo; //
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    return $stmt->execute([$userId]);
}
?>
