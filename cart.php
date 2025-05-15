<?php
// Database config

// Example user ID (normally from session)
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: sign_in.html");
    exit;
}

$customer_id = $_SESSION['user_id'];

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Fetch cart items for the customer
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.product_name, p.description, p.price,p.image, c.quantity
        FROM cart c
        JOIN product p ON c.product_id = p.product_id
        WHERE c.customer_id = :customer_id
    ");
    $stmt->execute(['customer_id' => $customer_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Backup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="cs/cart.css">
    <link rel="stylesheet" href="cs/backUp.css">
    <link rel="stylesheet" href="cs/back2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
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
        <div class="cart-icon">
            <a href="cart.php" style="color:white"><i class="fa-solid fa-cart-shopping"></i></a>
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
                    <a class="media-card" href="tahini.php">
                        <img src="img/sub1.png" alt="Tahini 1kg">
                        <p>Tahini 1kg <span class="arrow">→</span></p>
                    </a>
                    <a class="media-card" href="half.php">
                        <img src="img/sub2.png" alt="Tahini 0.5kg">
                        <p>Tahini 0.5kg <span class="arrow">→</span></p>
                    </a>
                    <a class="media-card" href="hole_sesame.php">
                        <img src="img/sub3.png" alt="Tahini Whole Sesame">
                        <p>Tahini Whole Sesame <span class="arrow">→</span> </p>
                    </a>
                    <a class="media-card" href="halva.php">
                        <img src="img/sub4.png" alt="Halva">
                        <p>Halva <span class="arrow">→</span></p>
                    </a>
                </div>
            </li>
            <li class="dropdown">
                <a href="ourStory.php" class="nav-link">Explore</a>
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

            if (isset($_SESSION['user_id'])): ?>
                <a href="php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                <span>Logout</span>
            <?php else: ?>
                <a href="Sign_in.html"><i class="fa-regular fa-user"></i></a>
                <span>Sign In</span>
            <?php endif; ?>
        </div>

    </div>

</header>

<div class="containerNew">
    <h2>Checkout</h2>

    <!-- Cart Display -->
    <h3>Your Cart</h3>
    <?php
    $total = 0;

    if (empty($cartItems)) {
        echo "<p>Your cart is empty.</p>";
    } else {
        foreach ($cartItems as $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $total += $lineTotal;

            echo "<div class='cart-item'>
             <img src='{$item['image']}' alt='{$item['product_name']}' class='product-image'>
                <h4>{$item['product_name']}</h4>
                <p>{$item['description']}</p>
                <p>Price: {$item['price']} NIS</p>
                <form method='POST' action='php/update_quantity.php' style='display: flex; gap: 10px; align-items: center;'>
                    <input type='hidden' name='product_id' value='{$item['product_id']}'>
                    <p>Quantity:</p>
                    <button type='submit' name='action' value='decrease' class='qty-btn'>−</button>
                    <span>{$item['quantity']}</span>
                    <button type='submit' name='action' value='increase' class='qty-btn'>+</button>
                </form>
                <p>Subtotal: " . number_format($lineTotal, 2) . " NIS</p>
                <form method='POST' action='php/remove_from_cart.php'>
                    <input type='hidden' name='product_id' value='{$item['product_id']}'>
                    <button type='submit' class='submit-btn hh'>Remove</button>
                </form>
              </div><hr>";
        }

        echo "<h3 style=' text-align: center; margin-bottom: 11px; margin-top: 11px;'>Total: " . number_format($total, 2) . " NIS</h3>";
    }
    ?>


    <!-- Checkout Form -->
    <form action="php/submit_checkout.php" method="POST">
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="address">Shipping Address:</label>
            <input type="text" name="address" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" required>
        </div>
        <input type="hidden" name="customer_id" value="<?= htmlspecialchars($customer_id) ?>">
        <button type="submit" class="submit-btn">Place Order</button>
    </form>
</div>


<!-- Left Section: Information & Contact -->
<footer class="footer">
    <div class="footer-container">
        <!-- Left Section: Information & Contact -->
        <div class="footer-info">
            <h3>Information</h3>
            <ul>

                <li><a href="catalog.php">Catalog</a></li>
                <li><a href="ourStory.php">Our Story</a></li>
                <li><a href="contactUs.php">Contact Us</a></li>
                <!--        <li><a href="#">Refund Policy</a></li>-->
                <!--        <li><a href="#">Terms of Service</a></li>-->
            </ul>
            <!--      <div class="footer-contact">-->
            <!--        <p><a href="tel:+970595061620">+ (970) 595061620</a></p>-->
            <!--        <p><a href="mailto:lana@harbracha.com">lana@harbracha.com</a></p>-->
            <!--        <p><a href="tel:+972522779569">+ (972) 522779569</a></p>-->
            <!--        <p><a href="mailto:zina@harbracha.com">zina@harbracha.com</a></p>-->
            <!--      </div>-->
            <div class="social-icons">
                <a href="https://www.facebook.com/HarBrachaTahini/"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/har_bracha_tahini/"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/@tahiniharbracha"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>

        <!-- Right Section: Newsletter & Social Media -->
        <div class="footer-newsletter">
            <h3>Stay in touch if something went wrong?</h3>
            <!--      <form action="#">-->
            <!--        <input type="email" placeholder="Enter your email" required>-->
            <!--        <button type="submit">➜</button>-->
            <!--      </form>-->
            <div class="footer-contact">
                <p><a href="tel:+970595061620">+ (970) 595061620</a></p>
                <p><a href="tel:+972522779569">+ (972) 522779569</a></p>
                <p><a href="mailto:lana@harbracha.com">lana@harbracha.com</a></p>

                <p><a href="mailto:zina@harbracha.com">zina@harbracha.com</a></p>

            </div>
            <!--      <div class="social-icons">-->
            <!--        <a href="https://www.facebook.com/HarBrachaTahini/"><i class="fa-brands fa-facebook-f"></i></a>-->
            <!--        <a href="https://www.instagram.com/har_bracha_tahini/"><i class="fab fa-instagram"></i></a>-->
            <!--        <a href="https://www.tiktok.com/@tahiniharbracha"><i class="fab fa-tiktok"></i></a>-->
            <!--      </div>-->
        </div>
    </div>
</footer>

<script src="scripts/script.js"></script>
</body>
</html>
