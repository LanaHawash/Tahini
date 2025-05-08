<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    // Optional: redirect to login or return error
    //header('Location: php/signIN.php');
    exit;
}
$dsn = "pgsql:host=localhost;dbname=tahini_db";
$user = "postgres";
$pass = "12217434";

$product_id = $_POST['product_id'];
$customer_id = $_POST['user_id'];
$customer_id = $_SESSION['user_id']; // safer and cleaner


try {
    $pdo = new PDO($dsn, $user, $pass);

    $stmt = $pdo->prepare("DELETE FROM cart WHERE customer_id = :customer_id AND product_id = :product_id");
    $stmt->execute([
        ':customer_id' => $customer_id,
        ':product_id' => $product_id
    ]);

    header("Location: ../cart.php");
    exit;

} catch (PDOException $e) {
    echo "Error removing product: " . $e->getMessage();
}
?>
