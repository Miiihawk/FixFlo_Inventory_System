<?php
// productController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_connection.php';


// DELETE PRODUCT
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

// ADD PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['add'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $unit_price = $_POST['unit_price'];
    $details = $_POST['details'] ?? null;

    $success = addProduct($name, $category_id, $stock, $unit_price, $details);

    if ($success) {
        header("Location: index.php?message=product_added");
        exit();
    } else {
        echo "Error adding product.";
    }
}

// SEARCH PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_id']) && isset($_POST['search'])) {
    $searchId = $_POST['search_id'];
    $product = getProductById(product_id: $searchId);

    if ($product) {
        $_SESSION['editProduct'] = $product;
        header("Location: AdminEdit.php");
        exit();
    } else {
        header("Location: AdminEdit.php?error=notfound");
        exit();
    }
}

// EDIT PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $unit_price = $_POST['unit_price'];
    $details = $_POST['details'] ?? null;

    $success = editProduct($product_id, $name, $category_id, $stock, $unit_price, $details);

    if ($success) {
        header("Location: AdminEdit.php?message=updated");
        exit();
    } else {
        header("Location: AdminEdit.php?error=updatefail");
        exit();
    }
}

// GET ALL PRODUCTS WITH CATEGORY (for listing)
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

// ADD PRODUCT FUNCTION
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

// EDIT PRODUCT FUNCTION
function editProduct($product_id, $name, $category_id, $stock, $unit_price, $details) {
    global $pdo;

    $sql = "UPDATE products 
            SET name = :name,
                category_id = :category_id,
                stock = :stock,
                unit_price = :unit_price,
                details = :details
            WHERE product_id = :product_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':unit_price', $unit_price);
    $stmt->bindParam(':details', $details);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    return $stmt->execute();
}

// GET PRODUCT BY ID FUNCTION
function getProductById($product_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}
