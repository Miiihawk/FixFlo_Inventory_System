<?php
//product controller
require_once 'db_connection.php';

function getAllProductsWithCategory() {
    global $pdo;
    $sql = "
        SELECT p.product_id, p.name AS product_name, c.name AS category_name, p.stock, p.unit_price, p.created_at
        FROM products p
        INNER JOIN categories c on p.category_id = c.category_id
        ORDER BY p.created_at DESC
    ";

    $stmt = $pdo->query($sql);
    return $stmt->fetchall();
}
?>