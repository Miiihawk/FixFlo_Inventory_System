<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("HTTP/1.1 403 Forbidden");
    echo "Access denied.";
    exit();
}

require_once 'productController.php';
require_once 'sortHelper.php';
require_once 'logController.php';

$search = $_GET['search'] ?? '';
$sortKey = $_GET['sort'] ?? null;

$products = getAllProductsWithCategory($search);

if ($sortKey && isset($products[0][$sortKey])) {
    $products = mergeSortProducts($products, $sortKey);
}
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FixFlo Dashboard</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="description" content="">
  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="icon" href="/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"/>
</head>

<body>

<div class="container">
  <!-- aside section start -->
  <aside>
    <div class="top">
      <div class="logo">
        <h2>FixFlo</h2>
      </div>
      <div class="close">
        <span class="material-symbols-outlined"> close </span>
      </div>
    </div>

    <div class="sidebar">
      <a href="#"><span class="material-symbols-outlined"> view_cozy </span><h3>Dashboard</h3></a>
      <a href="ManageUser.php"><span class="material-symbols-outlined"> manage_accounts </span><h3>Manage Users</h3></a>
      <a href="AdminAdd.php"><span class="material-symbols-outlined"> add </span><h3>Add Products</h3></a>
      <a href="AdminEdit.php"><span class="material-symbols-outlined"> edit </span><h3>Edit</h3></a>
      <a href="logout.php"><span class="material-symbols-outlined"> logout </span><h3>Logout</h3></a>
    </div>
  </aside>
  <!-- aside section end -->

  <!-- main section start -->
  <main>
    <h1>Dashboard</h1>

    <div class="top" style="display: flex; justify-content: space-between; align-items: center; gap: 16px;">
      <!-- Search -->
      <div class="Search">
        <form method="GET" action="index.php">
          <input type="text" name="search" placeholder="Search.." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
          <?php if (isset($_GET['sort'])): ?>
            <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
          <?php endif; ?>
        </form>
      </div>
      <!-- Sort  -->
      <div class="custom-select">
        <form method="GET" action="index.php">
          <?php if (isset($_GET['search'])): ?>
            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
          <?php endif; ?>
          <select name="sort" onchange="this.form.submit()">
            <option value="" disabled <?= !isset($_GET['sort']) ? 'selected' : '' ?>>Sort By</option>
            <option value="product_id" <?= ($_GET['sort'] ?? '') === 'product_id' ? 'selected' : '' ?>>ID</option>
            <option value="product_name" <?= ($_GET['sort'] ?? '') === 'product_name' ? 'selected' : '' ?>>Name</option>
            <option value="unit_price" <?= ($_GET['sort'] ?? '') === 'unit_price' ? 'selected' : '' ?>>Price</option>
            <option value="category_name" <?= ($_GET['sort'] ?? '') === 'category_name' ? 'selected' : '' ?>>Category</option>
          </select>
        </form>
      </div>
    </div>
    <!-- table -->
    <div class="recent_order">
      <h1>Products Table</h1>
      <table>
        <thead>
          <tr>
            <th style="width: 100px;">Product ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Payments</th>
            <th>Status</th>
            <th>Stock</th>
            <th>   </th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
            <tr>
              <td style="width: 100px;"><?= htmlspecialchars($product['product_id']) ?></td>
              <td><?= htmlspecialchars($product['product_name']) ?></td>
              <td><?= htmlspecialchars($product['category_name']) ?></td>
              <td>₱<?= number_format($product['unit_price'], 2) ?></td>
              <td><?= $product['stock'] > 0 ? 'Available' : 'Out of Stock' ?></td>
              <td style="text-align: center;">
                <form method="POST" action="productController.php" style="display:inline-flex; align-items:center; gap: 4px;">
                  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                  <input type="number" name="stock" value="<?= $product['stock'] ?>" min="0" style="width: 60px; text-align: center;">
                  <!--<button type="submit" name="update_stock">Update</button>-->
                </form>
              </td>
              <td><button type="submit" name="update_stock">Update</button></td>
              <td><?= htmlspecialchars($product['details'] ?? '-') ?></td>
              <td>
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 24px">
                  <!-- Delete button -->
                  <a href="productController.php?delete=<?= $product['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                    <span class="material-symbols-outlined" style="cursor:pointer;"> delete </span>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
  <!-- section end -->
  <div class="right">
    <div class="top">
      <button><span class="material-symbols-outlined"> menu</span></button>
      <div class="profile">
        <div class="info">
          <p><b><?= htmlspecialchars($_SESSION['username']) ?></b></p>
          <p><?= htmlspecialchars($_SESSION['role']) ?></p>
        </div>
        <div class="profile-photo">
          <img src="img/Profile.jpg" alt="">
        </div>
      </div>
    </div>

  <div class="recent_updates">
    <h2>Logs</h2>
    <div class="Logs">
      <table>
        <thead>
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= htmlspecialchars($log['product_name']) ?></td>
              <td style="color: <?= $log['quantity'] >= 0 ? 'green' : 'red' ?>">
                <?= ($log['quantity'] >= 0 ? '+' : '') . $log['quantity'] ?>
              </td>
              <td><?= htmlspecialchars($log['timestamp']) ?></td>
            </tr>
            <tr>
              <td colspan="3" style="font-style: italic; font-size: 0.9em; color: gray;">
                by <?= htmlspecialchars($log['username']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

  </div>

</div>

</body>
</html>
