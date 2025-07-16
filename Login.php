<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" href="css/Login.css">
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
      <div class="form-box active" id="login-form">
         <form action="authController.php" method="POST">
           <h2>FixFlo</h2>
           <input type="text" name="username" placeholder="Username" required>
           <input type="password" name="password" placeholder="Password" required>
           <button type="submit" name="Login">Login</button>

            <?php session_start(); if (isset($_SESSION['error'])): ?>
                <p style="color: red"><?=$_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

           <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
         </form>
      </div>

    <div class="form-box" id="register-form">
      <form action="#">
        <h2>FixFlo</h2>
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
        <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
      </form>
    </div>

  </div>

<script src="js/Script.js"></script>
</body>
</html>
