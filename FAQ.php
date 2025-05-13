<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FAQ's</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="cs/FAQ.css">
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
    <div class= "cart-icon">
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
          <li class="pe"><a href="./FAQ.php">FAQ'S</a></li>
          <li class="pe"><a href="./contactUs.php">Contact Us</a></li>

        </ul>
      </li>
      <li class="nav-item"><a href="./contactUs.php" class="nav-link">Contact</a></li>
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

<div class="faq-container1">
  <h1>FAQ's</h1>
  <p>Welcome to our FAQ, we are so happy to have you here and as a client.</p>
  <p>We have tried to answer the most common questions.</p>
</div>
<div class="faq-container2">
<div class="container ">
  <!-- FAQ Section -->
  <div class="faq-section">
    <div class="faq-section1">
    <h2 class="faq-title">Shipping & Returns</h2>
    <p class="faq-description">Below are some common questions about shipping, returns, and exchanges.</p>

    <div class="faq-item">
      <div class="faq-question">
        Do you offer international shipping?
        <span class="plus">+</span>
      </div>
      <div class="faq-answer">
        Yes, we offer international shipping to most countries.
      </div>
    </div>

    <div class="faq-item">
      <div class="faq-question">
        Can I place an order from outside Palestine on this website?
        <span class="plus" >+</span>
      </div>
      <div class="faq-answer">
        Yes, we accept international orders.
      </div>
    </div>
    </div>
    <div class="faq-section2">
      <h2 class="faq-title">Orders</h2>
      <p class="faq-description">Below are some of are common questions about orders</p>

      <div class="faq-item">
        <div class="faq-question">
          How long will it take to receive my order?
          <span class="plus">+</span>
        </div>
        <div class="faq-answer">
          Orders are typically processed and delivered within a week or less.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question">
          What payment methods are accepted?
          <span class="plus" >+</span>
        </div>
        <div class="faq-answer faq-payment">
          We accept payment via:
         <ul>
           <li>Credit Card</li>
           <li>PayPal</li>
           <li>Bit</li>
           <li>Paybox</li>
         <li> Cash (with an additional 25 shekel fee charged by the shipping company for cash handling)</li>
         </ul>
        </div>
      </div>
      <div class="faq-item">
        <div class="faq-question">
          Will I receive a confirmation of my purchase?
          <span class="plus" >+</span>
        </div>
        <div class="faq-answer">
          Yes, once your purchase is complete, you will receive a confirmation email with your order details.
        </div>
      </div>
      <div class="faq-item">
        <div class="faq-question">
          How can I change my shipping address?
          <span class="plus" >+</span>
        </div>
        <div class="faq-answer">
          To update your shipping address, please contact the shipping company directly. You will receive a notification via SMS on the day your order is shipped.
        </div>
      </div>
      <div class="faq-item">
        <div class="faq-question">
          Do you offer returns?
          <span class="plus" >+</span>
        </div>
        <div class="faq-answer">
          We do accept returns, and provide refunds if there is proof of a problem with your order. For more details, contact our support team.
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Form -->
  <div class="contact-form" >
    <h3>Didn’t find your answer?</h3>
    <p>Don't hesitate to contact us.</p>
    <div class="contact-inputs">
      <form action="php/contactUs.php" method="POST">
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="email" placeholder="Email">
    <textarea name="message" placeholder="Message"></textarea>
    <button type="submit" >Send message</button>
      </form>
    </div>
  </div>
</div>
</div>




<div class="info-container">
  <div class="info-box">
    <i class="fas fa-headset icon"></i>
    <h3>Customer service</h3>
    <p>It’s not actually free we just price it into the products.</p>
  </div>
  <div class="info-box">
    <i class="fas fa-truck icon"></i>
    <h3>Fast Free Shipping</h3>
    <p>Yes, We do offer Free shipping!</p>
  </div>
  <div class="info-box">
    <i class="fas fa-lock icon"></i>
    <h3>Secure payment</h3>
    <p>Your payment information is processed securely</p>
  </div>
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

<script src="scripts/script.js"></script>
<script src="scripts/FAQ.js"></script>
</body>
</html>