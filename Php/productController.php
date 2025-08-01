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
    redirectToDashboard();
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
        redirectToDashboard();
    }
}

// SEARCH PRODUCT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_id']) && isset($_POST['search'])) {
    $searchId = $_POST['search_id'];
    $redirect = $_POST['redirect_to'] ?? 'AdminEdit.php'; // fallback

    $product = getProductById(product_id: $searchId);

    if ($product) {
        $_SESSION['editProduct'] = $product;
        header("Location: $redirect");
        exit();
    } else {
        header("Location: $redirect?error=notfound");
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

    redirectToDashboard();

}

// UPDATE STOCK ONLY
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['stock'];

    if (is_numeric($product_id) && is_numeric($new_stock) && $new_stock >= 0) {
        updateStockOnly($product_id, (int)$new_stock);
    }

    redirectToDashboard();
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
            p.details,
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

// UPDATE STOCK QUANTITY
function updateStockOnly($product_id, $new_stock) {
    global $pdo;

    // Get the current stock first
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $currentProduct = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentProduct) {
        return; // product not found
    }

    $old_stock = (int)$currentProduct['stock'];
    $quantity_change = $new_stock - $old_stock;

    // Only proceed if there's an actual change
    if ($quantity_change !== 0) {
        // Update stock
        $stmt = $pdo->prepare("UPDATE products SET stock = :stock WHERE product_id = :product_id");
        $stmt->bindParam(':stock', $new_stock, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Insert into logs
        $user_id = $_SESSION['user_id'] ?? null;
        if ($user_id !== null) {
            $logStmt = $pdo->prepare("INSERT INTO logs (user_id, product_id, quantity, timestamp)
                                      VALUES (:user_id, :product_id, :quantity, NOW())");
            $logStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $logStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $logStmt->bindParam(':quantity', $quantity_change, PDO::PARAM_INT);
            $logStmt->execute();
        }
    }
}

// REDIRECT METHOD
function redirectToDashboard() {
    $role = $_SESSION['role'] ?? 'employee';
    if ($role === 'admin') {
        header("Location: index.php");
    } else {
        header("Location: Employee.php");
    }
    exit();
}

// GET ALL CATEGORIES
function getAllCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT category_id, name AS category_name FROM categories ORDER BY category_id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
