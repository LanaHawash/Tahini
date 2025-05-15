<?php

$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";
try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Get form values
    $cust_name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO overview (cust_name, email, message) VALUES (:cust_name, :email, :message)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cust_name' => $cust_name,
        ':email' => $email,
        ':message' => $message
    ]);
    echo "<script>
                alert('✅ Thank you! Your message submitted successfully!');
               window.location.href = '../contactUs.php'; // Redirect back to the previous page
              </script>";
    //echo "Message submitted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
