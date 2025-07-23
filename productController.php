<?php
// product controller
require_once 'db_connection.php';

function deleteProductById($productId) {
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];

    deleteProductById($productId);

    header("Location: index.php");
    exit();
}

function getAllProductsWithCategory($search = '') {
    global $pdo;
    $sql = "
        SELECT
            p.product_id,
            p.name AS product_name,
            c.name AS category_name,
            c.category_id,
            p.stock,
            p.unit_price,
            p.created_at
        FROM products p
        INNER JOIN categories c on p.category_id = c.category_id
    ";

    if (!empty($search)) {
        $sql .= " WHERE p.name LIKE :search OR c.name LIKE :search";
    }

    $stmt = $pdo->prepare($sql);

    if (!empty($search)) {
        $term = "%$search%";
        $stmt->bindParam(':search', $term);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}
