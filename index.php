<?php
require_once 'productController.php';

$search = $_GET['search'] ?? '';
$products = getAllProductsWithCategory($search);
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="css/style.css">
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

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
          <a href="#">
            <span class="material-symbols-outlined"> view_cozy </span>
            <h3>Dashboard</h3>
          </a>

          <a href="#">
            <span class="material-symbols-outlined"> manage_accounts </span>
            <h3>Manage Users</h3>
          </a>

          <a href="#">
          <span class="material-symbols-outlined"> settings </span>
          <h3>Settings</h3>
          </a>

      </div>

    </aside>
  <!-- aside section end -->

  <!-- main section start -->
  <main>
    <h1>Dashboard</h1>

    <div class="date">
      <form method="GET" action="index.php">
        <input type="text" name="search" placeholder="Search.." value="<?= htmlspecialchars($_GET['search'] ?? '')?>">
        <button type="submit">Search</button>
      </form>
    </div>

   <!-- end inside -->
      <!-- start recent order -->
    <div class="recent_order">
      <h1>Recent Order</h1>
      <table>
        <thead>
          <tr>
            <th>Product Number</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Payments</th>
            <th>Status</th>
          </tr>
        </thead>
          <tbody>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?= htmlspecialchars($product['product_id']) ?></td>
            <td><?= htmlspecialchars($product['product_name']) ?></td>
            <td><?= htmlspecialchars($product['category_name']) ?></td>
            <td>₱<?= number_format($product['unit_price'], 2) ?></td>
            <td>
              <?= $product['stock'] > 0 ? 'Available' : 'Out of Stock' ?>
            </td>
            <td><a href="#">Details</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
      <!-- end recent order -->
  </main>
  <!-- main section end -->
  <div class = "right">
    <div class="top">

      <button>
         <span class="material-symbols-outlined"> menu</span>
      </button>



      <div class="profile">
        <div class="info">
            <p><b>Hatdog</b></p>
            <p>Admin</p>
            <small class="text-muted"></small>
        </div>
        <div class="profile-photo">
          <img src="img/Profile.jpg" alt="">
        </div>
      </div>

    </div>

    <div class="recent_updates">
      <h2>Logs</h2>
    </div>
  </div>

</div>

</body>

</html>
