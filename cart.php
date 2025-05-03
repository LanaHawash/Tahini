<?php
// Database config



 // Example user ID (normally from session)

$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217434';
$dsn = "pgsql:host=$host;dbname=$db";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: php/signIn.html");
    exit;
}

$customer_id = $_SESSION['user_id'];

try {
    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.product_name, p.description, p.price, c.quantity
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
    <link rel="stylesheet" href="cs/backUp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="cs/cart.css">
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
        <div class= "cart-icon" onclick="openCart()">
            <a><i class="fa-solid fa-cart-shopping"></i></a>
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
                <a href="#" id="catalog-btn" class="nav-link">Catalog</a>
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
                <a href="explore.html" class="nav-link">Explore</a>
                <ul class="explore-menu" id="explore-submenu">
                    <li class="pe"><a href="#">Our Story</a></li>
                    <li class="pe"><a href="#">FAQ'S</a></li>
                    <li class="pe"><a href="#">Contact Us</a></li>

                </ul>
            </li>
            <li class="nav-item"><a href="contactUs.html" class="nav-link">Contact</a></li>
        </ul>


        <div class="sign-in">

            <a href="#"> <i class="fa-regular fa-user"></i></a>
            <span>Sign In</span>
        </div>





    </div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2>Cart</h2>
            <button class="close-btn" onclick="closeCart()">✖</button>
        </div>
        <div class="cart-content">
            <h3>Your cart is currently empty.</h3>
            <p>Not sure where to start? Try these collections:</p>
            <button class="continue-btn">Continue Shopping ➜</button>
        </div>
    </div>

    <div class="overlay" id="overlay" onclick="closeCart()"></div>

    <script src="scripts/script.js"></script>


</header>


<div class="containerNew">
    <h2>Checkout</h2>

    <!-- Cart Display -->
    <h3>Your Cart</h3>
    <?php
    $total = 0;

    if (count($cartItems) === 0) {
        echo "<p>Your cart is empty.</p>";
    } else {
        foreach ($cartItems as $item) {
            $lineTotal = $item['price'] * $item['quantity'];
            $total += $lineTotal;

            echo "<div class='cart-item'>
                    <h4>{$item['product_name']}</h4>

                    <p>{$item['description']}</p>
                    <p>Price: \${$item['price']} | Quantity: {$item['quantity']}</p>
                    <p>Subtotal: \$" . number_format($lineTotal, 2) . "</p>
                    <form method='POST' action='php/remove_from_cart.php'>
                        <input type='hidden' name='product_id' value='{$item['product_id']}'>
                        <input type='hidden' name='customer_id' value='{$customer_id}'>
                        <button type='submit' class='submit-btn' style='background-color:#dc3545;'>Remove</button>
                    </form>
                  </div><hr>";
        }

        echo "<h3>Total: \$" . number_format($total, 2) . "</h3>";
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
        <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
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
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
            </div>
        </div>
    </div>
</footer>



</body>
</html>