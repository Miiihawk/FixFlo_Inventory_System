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

require_once 'userController.php';
require_once 'sortHelper.php';

$users = getAllUsers();

if (isset($_GET['sort'])) {
    $sortKey = $_GET['sort'];
    $users = mergeSortProducts($users, $sortKey);
}
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="../css/Manage.css">
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

      <a href="#">
        <span class="material-symbols-outlined"> manage_accounts </span>
        <h3>Manage Users</h3>
      </a>

      <a href="AdminAdd.php">
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
    <h1>Manage User</h1>
    <div class="top">
      <div class="custom-select">
  <form method="GET" action="ManageUser.php">
    <select name="sort" onchange="this.form.submit()">
      <option value="" disabled <?= !isset($_GET['sort']) ? 'selected' : '' ?>>Sort By</option>
      <option value="user_id" <?= ($_GET['sort'] ?? '') === 'user_id' ? 'selected' : '' ?>>ID</option>
      <option value="username" <?= ($_GET['sort'] ?? '') === 'username' ? 'selected' : '' ?>>Username</option>
      <option value="role" <?= ($_GET['sort'] ?? '') === 'role' ? 'selected' : '' ?>>Role</option>
    </select>
  </form>
</div>

    </div>
    <!-- end inside -->
    <!-- start recent order -->
    <div class="recent_order">
      <h1>Accounts/Users</h1>
      <table>
        <thead>
          <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Date Created</th>
            <th>Date Updated</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['user_id']) ?></td>
              <td><?= htmlspecialchars($user['username']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
              <td><?= htmlspecialchars($user['created_at']) ?></td>
              <td><?= htmlspecialchars($user['updated_at']) ?></td>
              <td>
                <a href="manageUsers.php?delete=<?= $user['user_id'] ?>" onclick="return confirm('Delete this user?')">
                  <span class="material-symbols-outlined"> delete </span>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
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

    </div>




    </div>
  </div>

</div>
</body>

</html>
