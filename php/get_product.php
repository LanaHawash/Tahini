<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217434';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("Invalid ID");
    }

    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->prepare("SELECT product_id, product_name, image, price,quantity, description FROM product WHERE product_id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo json_encode(['error' => 'Product not found']);
        exit;
    }

    echo json_encode($product);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
