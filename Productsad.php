

<?php
// إعداد الاتصال بقاعدة بيانات PostgreSQL
$host = "localhost";
$dbname = "tahini_db";
$user = "postgres"; // عدّله إذا لزم الأمر
$password = "12217336"; // استبدله بكلمة مرور PostgreSQL الفعلية

$dsn = "pgsql:host=$host;dbname=$dbname";

try {
    $conn = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// إضافة منتج جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productName']) && $_POST['action'] === 'add') {
    $productName = $_POST['productName'];
    $description = $_POST['productDescription'];
    $price = floatval($_POST['productPrice']);
    $type = $_POST['productType'];
    $quantity = intval($_POST['quantity']);
    $date = date('Y-m-d');

    if (isset($_FILES['productImage']['tmp_name'])) {
        $image = file_get_contents($_FILES['productImage']['tmp_name']);

        $query = "INSERT INTO products (Product_name, Description, Price, Date, Quantity,typess,Image)
                  VALUES (:productName, :description, :price, :date, :quantity, :type, :image)";
        $stmt = $conn->prepare($query);

        try {
            $stmt->execute([
                ':productName' => $productName,
                ':description' => $description,
                ':price' => $price,
                ':date' => $date,
                ':quantity' => $quantity,
                ':type' => $type,
                ':image' => $image
            ]);
            echo "<script>alert('Product added successfully!');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

// حذف منتج
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $productId = intval($_POST['product_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE Product_id = :productId");

    try {
        $stmt->execute([':productId' => $productId]);
        echo "Product deleted successfully!";
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
    exit;
}

// تعديل منتج
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $productId = intval($_POST['product_id']);
    $productName = $_POST['Product_name'];
    $description = $_POST['Description'];
    $price = floatval($_POST['Price']);
    $type = $_POST['typess'];
    $quantity = intval($_POST['Quantity']);

    $query = "UPDATE products SET 
              Product_name = :productName,
              Description = :description,
              Price = :price,
              typess = :typess,
              Quantity = :quantity
              WHERE Product_id = :productId";

    $stmt = $conn->prepare($query);

    try {
        $stmt->execute([
            ':productName' => $productName,
            ':description' => $description,
            ':price' => $price,
            ':quantity' => $quantity,
            ':type' => $type,
            ':productId' => $productId
        ]);
        echo "Product updated successfully!";
    } catch (PDOException $e) {
        echo "Error updating product: " . $e->getMessage();
    }
    exit;
}

// جلب المنتجات لعرضها حسب النوع
$filterType = isset($_GET['filterType']) ? $_GET['filterType'] : 'all';
$whereClause = $filterType !== 'all' ? "WHERE typess = :filterType" : '';
$query = "SELECT * FROM products $whereClause";

$stmt = $conn->prepare($query);

try {
    if ($filterType !== 'all') {
        $stmt->execute([':filterType' => $filterType]);
    } else {
        $stmt->execute();
    }

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching products: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="cs/Admin.css">
    <title>Admin Product</title>
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
            <div class="profile-info">
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="Admin.html">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="#" class="activeM">
                    <i class="fa-solid fa-bowl-food"></i>
                    <span>Products</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="Customer.html">
                    <i class="fa-solid fa-user-group"></i>
                    <span>Customers</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="Orders.html">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <span>Orders</span>
                </a>
            </div>
        </div>

        <div align="center">
            <a href="index.php" class="logout-btn">Log Out</a>
        </div>
    </div>

</div>

<div class="main-content">
    <header>
        <h2>Admin Dashboard</h2>
        <div class="filter-bar">
            <label for="status-filter">Product Type:</label>
            <select id="status-filter" >
                <option value="all">All</option>
                <option value="skincare" >Tahini</option>
                <option value="haircare" >Halva</option>


            </select>
            <button class="btn-submit1" name="status-filter" onclick="applyFilter()">Apply Filter</button>
        </div>
    </header>
    <script>
        function applyFilter() {
            const filterType = document.getElementById('status-filter').value;
            const url = new URL(window.location.href);
            url.searchParams.set('filterType', filterType);
            window.location.href = url.toString();
        }

    </script>

    <section class="add-product">
        <h3>Add Product</h3>
        <form id="addProductForm" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="form-grid">
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" name="productName" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <textarea id="productDescription" name="productDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label for="productImage">Image</label>
                    <input type="file" id="productImage" name="productImage" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="productPrice">Price ($)</label>
                    <input type="number" id="productPrice" name="productPrice" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="productType">Product Type</label>
                    <select id="productType" name="productType" required>
                        <option value="">Select Type</option>
                        <option value="skincare">Tahini</option>
                        <option value="haircare">Halva</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div class="form-group" style="grid-column: span 2; text-align: center;">
                    <button type="submit" class="btn-submit">Add Product</button>
                </div>
            </div>
        </form>
    </section>

    <section class="products-list">
        <h3>All Products</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Type</th>
                <th>Price $</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="productTable">
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['Product_id']) ?></td>
                    <td>
                        <?php if (!empty($product['Image'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($product['Image']) ?>" alt="Product Image" style="max-width: 80px;">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($product['Product_name']) ?></td>
                    <td><?= htmlspecialchars($product['Description']) ?></td>
                    <td><?= htmlspecialchars($product['typess']) ?></td>
                    <td><?= number_format($product['Price'], 2) ?></td>
                    <td><?= intval($product['Quantity']) ?></td>
                    <td><?= htmlspecialchars($product['Date']) ?></td>
                    <td>
                        <button class="btn-action btn-edit" onclick="editProduct(this.parentElement.parentElement, <?= $product['Product_id'] ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" onclick="deleteProduct(<?= $product['Product_id'] ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

    </section>
</div>
</div>


<script>
    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            const formData = new FormData();
            formData.append("action", "delete");
            formData.append("product_id", productId);

            fetch("", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    const row = document.querySelector(`#product-${productId}`);
                    if (row) row.remove();
                })
                .catch(error => console.error("Error:", error));
        }
    }

    function editProduct(row, productId) {
        const cells = row.querySelectorAll("td");
        const editableIndexes = [2, 3, 4, 5, 6]; // Name, Description, Type, Price, Quantity
        const fieldNames = ["Product_name", "Description", "typess", "Price", "Quantity"];

        if (row.isEditing) {
            const formData = new FormData();
            formData.append("action", "edit");
            formData.append("product_id", productId);

            editableIndexes.forEach((index, i) => {
                const value = cells[index].querySelector("input").value;
                formData.append(fieldNames[i], value);
                cells[index].innerText = value;
            });

            fetch("", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    row.isEditing = false;
                })
                .catch(error => console.error("Error:", error));
        } else {
            editableIndexes.forEach(index => {
                const value = cells[index].innerText;
                cells[index].innerHTML = `<input type="text" value="${value}" style="width: 100%;">`;
            });
            row.isEditing = true;
        }
    }
</script>

</body>
</html>