<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cs/main.css">
    <link rel="stylesheet" href="cs/backUp.css">
    <link rel="stylesheet" href="cs/back2.css">

    <title>HarBracha Tahini</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


</head>
<body>
<!--adasadad-->
<div class="head">
    <div class="container">
        <div class="icons1">
        <ul>
            <li> <a href="https://www.facebook.com/HarBrachaTahini/"><i class="fa-brands fa-facebook-f"> </i></a></li>
            <li> <a href="https://www.instagram.com/har_bracha_tahini/"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="https://www.tiktok.com/@tahiniharbracha"> <i class="fa-brands fa-tiktok"></i></a></li>
        </ul>
        </div>
        <div class= "cart-icon">
            <a href="cart.php" style="color:white"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </div>
</div>
<header>
<div class="navbar">
<!--    hadhadajdhaj-->

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
            </li>            <li class="dropdown">
                <a href="ourStory.php" class="nav-link">Explore</a>
                <ul class="explore-menu" id="explore-submenu">
                    <li class="pe"><a href="ourStory.php">Our Story</a></li>
                    <li class="pe"><a href="./FAQ.php">FAQ'S</a></li>
                    <li class="pe"><a href="./contactUs.php">Contact Us</a></li>

                </ul>
            </li>            <li class="nav-item"><a href="contactUs.php" class="nav-link">Contact</a></li>
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



</header>

<div class="slider">
    <div class="slides">
        <div class="slide">
            <img src="img/Tahiniheader.webp" alt="Tahini Slide 1">
            <div class="hero-details">
                <h3>Welcome to Har Bracha Tahini!!</h3>
                <a href="./contactUs.php" class="button">Join Us</a>
            </div>
        </div>
        <div class="slide">
            <img src="img/Tahini3.jpg" alt="Tahini Slide 2">
            <div class="hero-details">
                <h3>The Best Or Nothing!!!</h3>
                <a href="./catalog.php" class="button">Buy Now</a>
            </div>
        </div>
        <div class="slide">
            <img src="img/factory.jpg" alt="Tahini Slide 3">
            <div class="hero-details">
                <h3>Handcrafted for You</h3>
                <a href="./ourStory.php" class="button">Explore More</a>
            </div>
        </div>
    </div>
</div>


<section class="hero-section">

    <div class="content">
        <h2 class="title">
            Har Bracha
            <span class="highlight">Tahini</span>
        </h2>
        <div class="buttond">
            <a href="ourStory.php" class="btn">
                Our Story <span class="arrow">→</span>
            </a>
        </div>
    </div>
    <div class="description-wrapper">
        <p class="description">
            Har Bracha Tahini is more than just a product; it's a brand deeply rooted in tradition, quality, and authenticity.
            Established with a commitment to producing the finest tahini, the brand prides itself on sourcing sesame seeds from the fertile region of Ethiopia, known for its ideal growing conditions.
        </p>
    </div>

</section>




<div class="video-background">
    <video autoplay muted loop class="background-video">
        <source src="img/video1.mp4" type="video/mp4">
    </video>
    <div class="contents">
        <h1 class="titles">The Best or Nothing</h1>
        <h2 class="subtitles">"Har Bracha Tahini: From Seed to <span class="highlights">Perfection</span>"</h2>
        <p class="descriptions">Experience the authentic taste of Har Bracha Tahini, crafted from the finest sesame seeds. This video reveals the care and tradition behind every jar, bringing quality and flavor to your table.</p>

        <div class="bb">
            <a href="./catalog.php" class="button">
                shop now <span class="arrow">→</span>
            </a>
        </div>
    </div>

</div>
<?php
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->query("SELECT * FROM product ORDER BY product_id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
die("Database error: " . $e->getMessage());
}
?>

<div class="product-container">
    <div class="product-head">
        <div class="product-h1"><h1>Har Bracha Tahini</h1></div>
        <div class="leftRightBTNs">
            <button class="slider-btn left">&lt;</button>
            <button class="slider-btn right">&gt;</button>
        </div>
    </div>
    <button class="collection-btn" onclick="window.location.href='catalog.php';">Collection</button>

    <div class="product-slider">
        <div class="product-list">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <div class="hover-overlay">
                        <form method="POST" action="php/add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <button type="submit" class="cart-btn" data-product-id="123">Add to cart</button>
                        </form>

                    </div>
                    <p class="rating">⭐ 5.0</p>
                </div>
                <div class="product-info">
                    <p class="product-name"><?= htmlspecialchars($product['product_name']) ?></p>
                    <p class="price"><?= number_format($product['price'], 2) ?> NIS</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
document.querySelectorAll(".cart-btn").forEach(button => {
button.addEventListener("click", function () {
const productId = this.dataset.productId;

fetch("Php/add_to_cart.php", {
method: "POST",
headers: {
"Content-Type": "application/x-www-form-urlencoded",
},
body: `product_id=${productId}&quantity=1`
})
.then(res => res.json())
.then(data => {
if (data.success) {
updateCartSidebar(data.cart);
openCart(); // Optional: Automatically open sidebar
} else {
alert(data.message || "Failed to add to cart.");
}
})
.catch(err => console.error("Error:", err));
});
});
});

function updateCartSidebar(cartItems) {
const cartContent = document.querySelector(".cart-content");
if (!cartItems.length) {
cartContent.innerHTML = `<h3>Your cart is currently empty.</h3>`;
return;
}

cartContent.innerHTML = cartItems.map(item => `
<div class="cart-item">
    <p>${item.product_name} - ${item.quantity} x $${item.price}</p>
</div>
`).join("");
}

</script>


<div class="video-background">
    <video autoplay muted loop class="background-video">
        <source src="img/video2.mp4" type="video/mp4">
    </video>
    <div class="contents">
        <h1 class="titles">The Best or Nothing</h1>
        <h2 class="subtitles">Ethiopia's Finest Sesame Seeds: <span class="highlights"> A Tradition of Quality</span></h2>
        <p class="descriptions">Our sesame seeds, sourced from Ethiopia's rich soils, are known for their exceptional quality. Partnering with trusted suppliers, we ensure every seed meets the highest standards.</p>

        <div class="bb">
            <a href="./ourHistory.php" class="button">
                Read More <span class="arrow">→</span>
            </a>
        </div>
    </div>

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
<script src="scripts/productSlider.js"></script>
</body>

</html>