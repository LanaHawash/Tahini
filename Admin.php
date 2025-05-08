<?php
// PDO connection to PostgreSQL
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Query to fetch the overview data
try {
    $stmt = $pdo->query("SELECT rating_id, message, email, cust_name FROM overview");

    // Fetch the data
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cs/Admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin</title>
</head>
<body>
<div class="page-wrapper">
    <div class="sidebar">
        <div class="brand">
            <h3>Har Bracha Tahini</h3>
        </div>
        <div class="profile-card">
            <div class="profile-img">
                <img class="dd" src="img/KIG5.png" alt="Profile Image">
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="menu-item"><a href="Admin.php" class="activeM"><i class="fas fa-home"></i><span>Home</span></a></div>
            <div class="menu-item"><a href="Productsad.php"><i class="fa-solid fa-bowl-food"></i><span>Products</span></a></div>
            <div class="menu-item"><a href="Customer.php"><i class="fa-solid fa-user-group"></i><span>Customers</span></a></div>
            <div class="menu-item"><a href="Orders.php"><i class="fa-solid fa-basket-shopping"></i><span>Orders</span></a></div>
        </div>
        <div align="center">
            <a href="index.php" class="logout-btn">Log Out</a>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>Admin Dashboard</h2>

    </header>

    <!-- Overview Table -->
    <div class="customers-list">
        <h3>All Overview</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Message</th>

            </tr>
            </thead>
           <tbody>
            <?php
            if ($rows) {
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['rating_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cust_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data available</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>
