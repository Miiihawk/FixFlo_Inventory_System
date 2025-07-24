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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $unit_price = $_POST['unit_price'];
    $details = isset($_POST['details']) ? $_POST['details'] : null;

    $success = addProduct($name, $category_id, $stock, $unit_price, $details);

    if ($success) {
        header("Location: index.php?message=product_added");
        exit();
    } else {
        echo "Error adding product.";
    }
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

function addProduct($name, $category_id, $stock, $unit_price, $details = null) {
    global $pdo;

    $sql = "INSERT INTO products (name, category_id, stock, unit_price, details) 
            VALUES (:name, :category_id, :stock, :unit_price, :details)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':unit_price', $unit_price);
    $stmt->bindParam(':details', $details);

    return $stmt->execute();
}
