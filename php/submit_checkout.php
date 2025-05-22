<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: php/signIn.php');
    exit;
}

// DB config
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$customer_id = $_POST['customer_id'];

try {
    // Establish database connection
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Step 1: Update or insert user info
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

    // Step 2: Fetch cart items
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.product_name, p.description, p.price, c.quantity
        FROM cart c
        JOIN product p ON c.product_id = p.product_id
        WHERE c.customer_id = :customer_id
    ");
    $stmt->execute([':customer_id' => $customer_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($cartItems)) {
        echo "<p style='font-family: sans-serif; text-align: center; margin-top: 50px;'>❌ Your cart is empty. Cannot place an order.</p>";
        exit;
    }

    // Step 3: Calculate total price
    $total_price = 0;
    foreach ($cartItems as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Step 4: Save order with JSON details
    $orderDetails = [];
    foreach ($cartItems as $item) {
        $orderDetails[] = [
            'product_name' => $item['product_name'],
            'price' => $item['price'],
            'quantity' => $item['quantity']
        ];
    }

    // Convert the order details to JSON
    $orderDetailsJson = json_encode($orderDetails);

    // Step 5: Insert into the orders table
    $stmt = $pdo->prepare("
        INSERT INTO orders (order_details, status, total_price, customer_id)
        VALUES (:order_details, 'Processing', :total_price, :customer_id)
    ");
    $stmt->execute([
        ':order_details' => $orderDetailsJson,
        ':total_price' => $total_price,
        ':customer_id' => $customer_id
    ]);

    // Get the last inserted order_id
    $order_id = $pdo->lastInsertId();

    // Step 6: Insert into product_orders table and update product quantity
    foreach ($cartItems as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // Insert into product_orders table
        $stmt = $pdo->prepare("
            INSERT INTO product_orders (order_id, product_id, quantity)
            VALUES (:order_id, :product_id, :quantity)
        ");
        $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':quantity' => $quantity
        ]);

        // Decrease the quantity in the product table
        $stmt = $pdo->prepare("
            UPDATE product
            SET quantity = quantity - :ordered_quantity
            WHERE product_id = :product_id AND quantity >= :ordered_quantity
        ");
        $stmt->execute([
            ':ordered_quantity' => $quantity,
            ':product_id' => $product_id
        ]);
    }

    // Step 7: Clear the cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE customer_id = :customer_id");
    $stmt->execute([':customer_id' => $customer_id]);

    // Success response
    echo "<script>
            alert('✅ Thank you! Your order has been placed successfully.');
            window.location.href = '../index.php';
          </script>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
