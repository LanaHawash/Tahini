<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Backup</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="cs/catalog.css">
  <link rel="stylesheet" href="cs/backUp.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>
<div class="head">
  <div class="container">
    <div class="icons1">
      <ul>
        <li> <a href="https://www.facebook.com/HarBrachaTahini/"><i class="fa-brands fa-facebook-f"> </i></a></li>
        <li> <a href="https://www.instagram.com/har_bracha_tahini/"><i class="fa-brands fa-instagram"></i></a></li>
        <li><a href="https://www.tiktok.com/@tahiniharbracha"> <i class="fa-brands fa-tiktok"></i></a></li>
      </ul>
    </div>
    <div class= "cart-icon" >
      <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
  </div>
</div>
<header>
  <div class="navbar">

    <a href="index.php" class="logo-img"> <img src="img/icon.png" alt="logo"/></a>
    <div class="menu-toggle" onclick="toggleMenu()">
      <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="nav-menu">
      <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
      <li class="dropdown">
        <a href="catalog.php" id="catalog-btn" class="nav-link">Catalog</a>
        <div class="submenu" id="submenu">
          <div class="media-card">
            <img src="img/sub1.png" alt="Tahini 1kg">
            <p>Tahini 1kg <span class="arrow">→</span></p>
          </div>
          <div class="media-card">
            <img src="img/sub2.png" alt="Tahini 0.5kg">
            <p>Tahini 0.5kg <span class="arrow">→</span></p>
          </div>
          <div class="media-card">
            <img src="img/sub3.png" alt="Tahini Whole Sesame">
            <p>Tahini Whole Sesame <span class="arrow">→</span> </p>
          </div>
          <div class="media-card">
            <img src="img/sub4.png" alt="Halva">
            <p>Halva <span class="arrow">→</span></p>
          </div>
        </div>
      </li>
      <li class="dropdown">
        <a href="index.php" class="nav-link">Explore</a>
        <ul class="explore-menu" id="explore-submenu">
          <li class="pe"><a href="ourStory.php">Our Story</a></li>
          <li class="pe"><a href="FAQ.php">FAQ'S</a></li>
          <li class="pe"><a href="contactUs.php">Contact Us</a></li>

        </ul>
      </li>
      <li class="nav-item"><a href="contactUs.php" class="nav-link">Contact</a></li>
    </ul>



    <div class="sign-in">
      <?php
        session_start();
        if (isset($_SESSION['user_id'])): ?>
      <a href="php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
      <span>Logout</span>
      <?php else: ?>
      <a href="Sign_in.html"><i class="fa-regular fa-user"></i></a>
      <span>Sign In</span>
      <?php endif; ?>
    </div>





  </div>

  <script src="scripts/script.js"></script>


</header>
<?php
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217434';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->query("SELECT product_name, image, description FROM product"); // Adjust columns if needed
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            <div class="product-title">
                <?= htmlspecialchars($product['product_name']) ?>
                <span><i class="fa-solid fa-arrow-right" style="color: #000000;"></i></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<!-- Left Section: Information & Contact -->
<footer class="footer">
  <div class="footer-container">
    <!-- Left Section: Information & Contact -->
    <div class="footer-info">
      <h3>Information</h3>
      <ul>
        <li><a href="#">Search</a></li>
        <li><a href="#">Catalog</a></li>
        <li><a href="#">Our Story</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Refund Policy</a></li>
        <li><a href="#">Terms of Service</a></li>
      </ul>
      <div class="footer-contact">
        <p><a href="tel:+972585218207">+ (972) 585218207</a></p>
        <p><a href="mailto:jad@harbracha.com">jad@harbracha.com</a></p>
      </div>
    </div>

    <!-- Right Section: Newsletter & Social Media -->
    <div class="footer-newsletter">
      <h3>Stay in the loop with our weekly newsletter</h3>
      <form action="#">
        <input type="email" placeholder="Enter your email" required>
        <button type="submit">➜</button>
      </form>
        <div class="social-icons">
            <a href="https://www.facebook.com/HarBrachaTahini/"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/har_bracha_tahini/"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@tahiniharbracha"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>
  </div>
</footer>



</body>
</html>