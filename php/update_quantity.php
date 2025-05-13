<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit('Not logged in');
}

$customer_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$action = $_POST['action'];

$dsn = "pgsql:host=localhost;dbname=tahini_db";
$user = "postgres";
$pass = "12217336";

try {
    $pdo = new PDO($dsn, $user, $pass);

    if ($action === 'increase') {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE customer_id = :customer_id AND product_id = :product_id");
    } elseif ($action === 'decrease') {
        // Optional: Don't let quantity go below 1
        $stmt = $pdo->prepare("
            UPDATE cart 
            SET quantity = GREATEST(quantity - 1, 1) 
            WHERE customer_id = :customer_id AND product_id = :product_id
        ");
    }

    $stmt->execute([
        ':customer_id' => $customer_id,
        ':product_id' => $product_id
    ]);

    header("Location: ../cart.php");
    exit;

} catch (PDOException $e) {
    echo "Error updating quantity: " . $e->getMessage();
}
?>
