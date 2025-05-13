<?php
// Database connection settings for PostgreSQL
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    // Create a PDO connection
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle the GET request for filtering orders by status
    $filterStatus = isset($_GET['status']) ? $_GET['status'] : 'all';
    $whereClause = '';

    if ($filterStatus !== 'all') {
        $whereClause = "WHERE o.status = :status";
    }

    // SQL query to fetch orders with optional status filtering
    $sql = "
    SELECT o.order_id, o.order_date, o.status, o.total_price, 
           c.name AS customer_name, 
           STRING_AGG(p.product_name, ', ') AS products
    FROM orders o
    JOIN users c ON o.customer_id = c.id
    JOIN product_orders op ON o.order_id = op.order_id
    JOIN product p ON op.product_id = p.product_id
    $whereClause
    GROUP BY o.order_id, c.name";

    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);

    if ($filterStatus !== 'all') {
        $stmt->bindParam(':status', $filterStatus, PDO::PARAM_STR);
    }

    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle POST requests for updating order status
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['orderId']) && isset($_POST['status'])) {
            $orderId = $_POST['orderId'];
            $status = $_POST['status'];
            $allowedStatuses = ['Completed', 'Pending', 'Cancelled'];

            if (!empty($orderId) && !empty($status) && in_array($status, $allowedStatuses)) {
                $updateSql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
                $updateStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);

                if ($updateStmt->execute()) {
                    echo json_encode(["success" => "Order status updated successfully!"]);
                } else {
                    echo json_encode(["error" => "Failed to update order status"]);
                }
            } else {
                echo json_encode(["error" => "Invalid status or missing parameters."]);
            }
            exit;
        }
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="cs/Admin.css">
</head>
<body>

<div class="page-wrapper">
    <div class="sidebar">
        <div class="brand">
            <h3>Har Bracha Tahini</h3>
        </div>

        <div class="profile-card">
            <div class="profile-img">
                <img class="dd" src="img/KIG5.png">
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="Admin.php">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="Productsad.php">
                    <i class="fa-solid fa-bowl-food"></i>
                    <span>Products</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="Customer.php">
                    <i class="fa-solid fa-user-group"></i>
                    <span>Customers</span>
                </a>
            </div>
            <div class="menu-item" >
                <a href="Orders.php" class="activeM">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <span>Orders</span>
                </a>
            </div>
        </div>

        <div align="center">
            <a href="index.php" class="logout-btn">Log Out</a>
        </div>
    </div>


    <div class="main-content">
        <header>
            <h2>Admin Dashboard</h2>
            <div class="filter-bar">
                <label for="status-filter">Filter by Status:</label>
                <select id="status-filter">
                    <option value="all">All</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button class="btn-submit1">Apply Filter</button>
            </div>
        </header>

        <div class="orders-list">
            <h3>Orders List</h3>
            <table id="orders-table">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['order_id']) ?></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><?= htmlspecialchars($row['products']) ?></td>
                            <td><span class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                            <td><?= htmlspecialchars($row['total_price']) ?>NIS</td>
                            <td><?= htmlspecialchars($row['order_date']) ?></td>
                            <td>
                                <button class="btn-action" data-id="<?= $row['order_id'] ?>" data-status="Completed">✔️</button>
                                <button class="btn-action" data-id="<?= $row['order_id'] ?>" data-status="Pending">🕑</button>
                                <button class="btn-action" data-id="<?= $row['order_id'] ?>" data-status="Cancelled">❌</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No orders found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>document.addEventListener("DOMContentLoaded", function () {
        // Handle order status update
        document.querySelectorAll(".btn-action").forEach(function (button) {
            button.addEventListener("click", function () {
                const row = this.closest("tr");
                const orderId = row.querySelector("td:first-child").innerText;
                const status = this.dataset.status;

                if (status) {
                    fetch("orders.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `orderId=${orderId}&status=${status}`,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.error) {
                                alert("Error: " + data.error);
                            } else {
                                // Update the row based on the returned data
                                const statusCell = row.querySelector(".status");
                                if (statusCell) {
                                    statusCell.innerText = status;
                                    statusCell.className = `status ${status.toLowerCase()}`;
                                }
                                alert("Order status updated successfully!");
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert("An error occurred while updating the status.");
                        });
                }
            });
        });

        // Handle order filtering
        const statusFilter = document.getElementById("status-filter");
        const applyFilterButton = document.querySelector(".btn-submit1");

        applyFilterButton.addEventListener("click", function () {
            const selectedStatus = statusFilter.value;
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set("status", selectedStatus);
            window.location.search = urlParams.toString();
        });
    });

</script>

</body>
</html>
