<?php
// DB connection settings
$host = 'localhost';
$dbname = 'tahini_db';
$user = 'postgres';
$password = '12217434';



try {
    // Create PDO connection
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Collect form data
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $passwordPlain = $_POST['password'];

        // Basic validation
        if (strlen($name) < 4 || strlen($passwordPlain) < 4 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid input.";
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($passwordPlain, PASSWORD_BCRYPT);

        // Insert into DB
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        echo"<script>
                    alert('Sign-Up successful! Welcome, $name.');
                    window.location.href = '../Sign_in.html';
                  </script>";

        // Redirect or show success message
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
