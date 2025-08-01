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
$categories = getAllCategories();
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="../css/Add.css">
  <meta name="description" content="">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta property="og:image:alt" content="">

  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="icon" href="/icon.svg" type="image/svg+xml">
  <link rel="apple-touch-icon" href="../icon.png">

  <link rel="manifest" href="../site.webmanifest">
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
    <!-- end top -->

    <div class="sidebar">
      <a href="index.php">
        <span class="material-symbols-outlined"> view_cozy </span>
        <h3>Dashboard</h3>
      </a>

      <a href="ManageUser.php">
        <span class="material-symbols-outlined"> manage_accounts </span>
        <h3>Manage Users</h3>
      </a>

      <a href="#">
        <span class="material-symbols-outlined"> add </span>
        <h3>Add Products</h3>
      </a>

      <a href="AdminEdit.php">
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

    <!-- end inside -->
    <!-- start recent order -->
    <main>
        <div class="recent_order">
            <h2>Add Product</h2>
            <form action="productController.php" method="POST" class="table">

            <div class="Space">
                <h3>Name</h3>
                <input type="text" name="name" placeholder="ex. Hammer..." required>
            </div>

            <div class="Space">
                <h3>Category ID</h3>
                <input type="number" name="category_id" placeholder="ex. 1..." required>
            </div>

            <div class="Space">
                <h3>Stock</h3>
                <input type="number" name="stock" placeholder="ex. 50..." required>
            </div>

            <div class="Space">
                <h3>Unit Price</h3>
                <input type="number" step="0.01" name="unit_price" placeholder="ex. 1000.00..." required>
            </div>

            <div class="Space">
                <h3>Details</h3>
                <textarea class="Details" name="details" rows="6" cols="50" placeholder="Enter description or extra notes (optional)..."></textarea>
            </div>

            <div class="Button">
                <button type="submit" name="add">Add Product</button>
            </div>

            </form>
        </div>
    </main>
    <!-- end recent order -->
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
          <img src="../img/Profile.jpg" alt="">
        </div>
      </div>

      <div class="recent_updates">
        <h2>Category</h2>
        <div class="Logs">
          <table>
            <thead>
            <tr>
              <th>ID</th>
              <th>Category</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
              <tr>
                <td><?= htmlspecialchars($category['category_id']) ?></td>
                <td><?= htmlspecialchars($category['category_name']) ?></td>
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
