<?php


session_start();

if (!isset($_SESSION['user_id'])) {
    // Optional: redirect to login or return error
    header('Location: ../sign_in.html');
    exit;
}

$customer_id = $_SESSION['user_id'];


$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);

    // Validate input
    if (!isset($_POST['product_id'])) {
        throw new Exception("Product ID is required.");
    }


    $product_id = $_POST['product_id'];

    // Assume customer is logged in and ID is stored in session
    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;



    if (!$customer_id) {
        throw new Exception("You must be logged in to add to cart.");
    }
    $stmt = $pdo->prepare("SELECT quantity FROM product WHERE product_id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Product not found.");
    }

    if ($product['quantity'] <= 0) {
        echo "<script>
            alert('Sold Out: This product is not available.');
            window.location.href = '../catalog.php';
          </script>";

    }
    else{
    // Check if product is already in cart
    $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE customer_id = :customer_id AND product_id = :product_id");
    $stmt->execute([
        ':customer_id' => $customer_id,
        ':product_id' => $product_id
    ]);

    if ($stmt->rowCount() > 0) {
        // Product exists in cart, update quantity
        $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE customer_id = :customer_id AND product_id = :product_id")
            ->execute([
                ':customer_id' => $customer_id,
                ':product_id' => $product_id
            ]);
    } else {
        // Product not in cart, insert new row
        $pdo->prepare("INSERT INTO cart (customer_id, product_id, quantity) VALUES (:customer_id, :product_id, 1)")
            ->execute([
                ':customer_id' => $customer_id,
                ':product_id' => $product_id
            ]);
    }

        echo "<script>
        alert('Product added successfully! please continue shopping.<3');
        window.location.href = '../catalog.php';
    </script>";
        exit;
}
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

