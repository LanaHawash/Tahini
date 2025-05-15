<?php
session_start();

// DB Config
$host = 'localhost';
$dbname = 'tahini_db';
$user = 'postgres';
$pass = '12217336';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            echo "Please fill in all fields.";
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: ../Admin.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            echo "<script>
                alert('Invalid email or password. Please try again.');
                window.history.back(); // Redirect back to the previous page
              </script>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
