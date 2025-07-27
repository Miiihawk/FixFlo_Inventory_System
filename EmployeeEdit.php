<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$product = isset($_SESSION['editProduct']) ? $_SESSION['editProduct'] : null;
require_once 'productController.php';
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Product</title>
  <link rel="stylesheet" href="css/Edit.css">
  <meta name="description" content="">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta property="og:image:alt" content="">

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
      <a href="Employee.php">
        <span class="material-symbols-outlined"> view_cozy </span>
        <h3>Dashboard</h3>
      </a>

      <a href="EmployeeAdd.php">
        <span class="material-symbols-outlined"> add </span>
        <h3>Add Products</h3>
      </a>

      <a href="#">
        <span class="material-symbols-outlined"> edit </span>
        <h3>Edit</h3>
      </a>

      <a href="LogOut.php">
        <span class="material-symbols-outlined"> logout </span>
        <h3>Logout</h3>
      </a>
    </div>
  </aside>
  <!-- aside section end -->

  <!-- main section start -->
  <main>
    <div class="recent_order">
      <h2>Edit Products</h2>
      <div class="table">
        <form method="POST" action="productController.php">
          <?php if (isset($_GET['message']) && $_GET['message'] === 'updated'): ?>
            <p style="color: green;">Product updated successfully.</p>
          <?php endif; ?>

          <?php if (isset($_GET['error']) && $_GET['error'] === 'not_found'): ?>
            <p style="color: red;">Product not found.</p>
          <?php endif; ?>

          <div class="Space">
            <h3>Search ID</h3>
            <input type="text" name="search_id" placeholder="ex. 1001"
                  value="<?= isset($product) ? htmlspecialchars($product['product_id']) : '' ?>">
            
            <!-- This input won't affect your layout -->
            <input type="hidden" name="redirect_to" value="EmployeeEdit.php">

            <div class="Button">
              <button type="submit" name="search">Search</button>
            </div>
          </div>

          <input type="hidden" name="product_id" value="<?= isset($product) ? htmlspecialchars($product['product_id']) : '' ?>">

          <div class="Space">
            <h3>Name</h3>
            <input type="text" name="name" placeholder="ex. Hammer..." value="<?= isset($product) ? htmlspecialchars($product['name']) : '' ?>">
          </div>

          <div class="Space">
            <h3>Category</h3>
            <input type="text" name="category_id" placeholder="ex. Paint..." value="<?= isset($product) ? htmlspecialchars($product['category_id']) : '' ?>">
          </div>

          <div class="Space">
            <h3>Price</h3>
            <input type="text" name="unit_price" placeholder="ex. 1000..." value="<?= isset($product) ? htmlspecialchars($product['unit_price']) : '' ?>">
          </div>

          <div class="Space">
            <h3>Stock</h3>
            <input type="text" name="stock" placeholder="ex. 50" value="<?= isset($product) ? htmlspecialchars($product['stock']) : '' ?>">
          </div>

          <div class="Space">
            <h3>Details</h3>
            <textarea class="Details" name="details" rows="20" cols="107"><?= isset($product) ? htmlspecialchars($product['details']) : '' ?></textarea>
          </div>

          <div class="Button">
            <button type="submit" name="update">Update Product</button>
          </div>
        </form>
      </div>
    </div>
  </main>
  <!-- main section end -->

  <div class="right">
    <div class="top">
      <button>
        <span class="material-symbols-outlined"> menu</span>
      </button>

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
          <tbody>
          <tr><td>Mini USB</td></tr>
          <tr><td>Mini USB</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
