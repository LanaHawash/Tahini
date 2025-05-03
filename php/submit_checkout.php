<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    // Optional: redirect to login or return error
    header('Location: php/signIN.php');
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

    // Insert or update into Users table
    $stmt = $pdo->prepare("
        INSERT INTO users (id, email, address, phone)
        VALUES (:id, :email, :address, :phone)
        ON CONFLICT (id)
        DO UPDATE SET Address = EXCLUDED.Address, Phone = EXCLUDED.Phone
    ");
    $stmt->execute([
        ':id' => $customer_id,
        ':email' => $email,
        ':address' => $address,
        ':phone' => $phone
    ]);

    echo "<p style='font-family: sans-serif; text-align: center; margin-top: 50px;'>
            ✅ Thank you! Your order has been placed successfully.
          </p>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
