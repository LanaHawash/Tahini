<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: php/signIn.php');
    exit;
}

$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217434';
$dsn = "pgsql:host=$host;dbname=$db";

$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$customer_id = $_POST['customer_id'];

try {
    $pdo = new PDO($dsn, $user, $pass);

    // Update user info
    $stmt = $pdo->prepare("
        INSERT INTO users (id, email, address, phone)
        VALUES (:id, :email, :address, :phone)
        ON CONFLICT (id)
        DO UPDATE SET address = EXCLUDED.address, phone = EXCLUDED.phone
    ");
    $stmt->execute([
        ':id' => $customer_id,
        ':email' => $email,
        ':address' => $address,
        ':phone' => $phone
    ]);

    // Fetch cart items
    $stmt = $pdo->prepare("
        SELECT p.product_name, p.price, c.quantity
        FROM cart c
        JOIN product p ON c.product_id = p.product_id
        WHERE c.customer_id = :customer_id
    ");
    $stmt->execute([':customer_id' => $customer_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cartItems) === 0) {
        echo "Your cart is empty. Cannot place an order.";
        exit;
    }

    // Prepare order details and total
    $orderDetails = "";
    $total = 0;

    foreach ($cartItems as $item) {
        $lineTotal = $item['price'] * $item['quantity'];
        $total += $lineTotal;
        $orderDetails .= "{$item['product_name']} (x{$item['quantity']}) - $" . number_format($lineTotal, 2) . "\n";
    }

    // Insert into orders table
    $stmt = $pdo->prepare("
        INSERT INTO orders (order_date, order_details, status, total_price, customer_id)
        VALUES (NOW(), :order_details, 'Pending', :total_price, :customer_id)
    ");
    $stmt->execute([
        ':order_details' => $orderDetails,
        ':total_price' => $total,
        ':customer_id' => $customer_id
    ]);

    // Clear the cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE customer_id = :customer_id");
    $stmt->execute([':customer_id' => $customer_id]);

    echo "<p style='font-family: sans-serif; text-align: center; margin-top: 50px;'>
            ✅ Thank you! Your order has been placed successfully.
          </p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
