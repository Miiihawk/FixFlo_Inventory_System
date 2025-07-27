<?php
require_once 'db_connection.php'; // This should define $pdo

$sql = "SELECT 
            logs.*, 
            products.name AS product_name, 
            users.username
        FROM logs
        JOIN products ON logs.product_id = products.product_id
        JOIN users ON logs.user_id = users.user_id
        ORDER BY logs.timestamp DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
