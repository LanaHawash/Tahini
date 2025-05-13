<?php
session_start();
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->query("SELECT product_id, product_name, image, description FROM product");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="cs/catalog.css">
    <link rel="stylesheet" href="cs/backUp.css">
</head>
<body>
<div class="head">
    <div class="container">
        <div class="icons1">
            <ul>
                <li><a href="https://www.facebook.com/HarBrachaTahini/"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="https://www.instagram.com/har_bracha_tahini/"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="https://www.tiktok.com/@tahiniharbracha"><i class="fa-brands fa-tiktok"></i></a></li>
            </ul>
        </div>
        <div class="cart-icon">
            <a href="cart.php" style="color:white"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </div>
</div>

<header>
    <div class="navbar">
        <a href="index.php" class="logo-img"><img src="img/icon.png" alt="logo"/></a>
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
                    <li class="pe"><a href="./FAQ.php">FAQ'S</a></li>
                    <li class="pe"><a href="./contactUs.php">Contact Us</a></li>

                </ul>
            </li>            <li class="nav-item"><a href="contactUs.php" class="nav-link">Contact</a></li>
        </ul>
        <div class="sign-in">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a><span>Logout</span>
            <?php else: ?>
                <a href="Sign_in.html"><i class="fa-regular fa-user"></i></a><span>Sign In</span>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product-card" data-id="<?= htmlspecialchars($product['product_id']) ?>" onclick="fetchProduct(this)">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
            <div class="product-title">
                <?= htmlspecialchars($product['product_name']) ?>
                <span><i class="fa-solid fa-arrow-right" style="color: #000000;"></i></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Product Modal -->
<div id="productModal" class="modal ">
    <div class="modal-header">
    <div class="image-section">
        <img id="modalImage" src="" alt="Product Image">
    </div>
    <div class="modal-content" >
        <span class="close-button" onclick="closeModall()">×</span>

        <h2 id="modalTitle" class="title" ></h2>
        <h4 class="description" id="modalDescription" ></h4>
        <p id="modalPrice" class="price"></p>
        <form method="POST" action="php/add_to_cart.php">

            <input type="hidden" name="product_id" id="modalProductId">

            <button type="submit" class="add">Add to cart</button>
        </form>
    </div>
</div>
</div>


<footer class="footer">
    <div class="footer-container">
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
<script>
    function fetchProduct(el) {
        const productId = el.dataset.id;

        fetch(`php/get_product.php?id=${productId}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert("Product not found");
                    return;
                }

                document.getElementById('modalImage').src = data.image;
                document.getElementById('modalTitle').textContent = data.product_name;
                document.getElementById('modalPrice').textContent = data.price + ' NIS';
                document.getElementById('modalDescription').textContent = data.description;
                document.getElementById('modalProductId').value = data.product_id;

                document.getElementById('productModal').style.display = 'flex';
                document.body.classList.add('modal-open');
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert("Error loading product");
            });
    }

    function closeModall() {
        document.getElementById('productModal').style.display = 'none';
        document.body.classList.remove('modal-open');
    }
</script>
<script src="scripts/script.js"></script>

</body>
</html>
