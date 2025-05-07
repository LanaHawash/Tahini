
<?php
$host = 'localhost';
$db = 'tahini_db';
$user = 'postgres';
$pass = '12217336';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Add Product
        if ($_POST['action'] === 'add') {
            // Ensure the uploads directory exists
            $uploadDir = 'img/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
            }

            // Handle file upload
            $fileName =$uploadDir. basename($_FILES['productImage']['name']); // Generate unique filename
            $uploadFile = $fileName;

            if (move_uploaded_file($_FILES['productImage']['tmp_name'], $uploadFile)) {
                // Save product data including the file path in the database
                $stmt = $pdo->prepare("INSERT INTO product (product_name, description, price, quantity, type, image) 
                                       VALUES (:name, :description, :price, :quantity, :type, :image)");
                $stmt->execute([
                    ':name' => $_POST['productName'],
                    ':description' => $_POST['productDescription'],
                    ':price' => $_POST['productPrice'],
                    ':quantity' => $_POST['quantity'],
                    ':type' => $_POST['productType'],
                    ':image' => $fileName // Save the file name in the database
                ]);
                echo "<script>alert('Product added successfully!');</script>";
            } else {
                echo "<script>alert('Error uploading the image.');</script>";
            }
        }

        // Delete Product
        elseif ($_POST['action'] === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM product WHERE product_id = :id");
            $stmt->execute([':id' => $_POST['product_id']]);
            echo "Product deleted successfully!";
            exit;
        }

        // Edit Product
        elseif ($_POST['action'] === 'edit') {
            // Check if product ID is present
            if (isset($_POST['product_id'])) {
                $productId = $_POST['product_id'];

                // Retrieve existing product data from the database
                $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = :id");
                $stmt->execute([':id' => $productId]);
                $product = $stmt->fetch();

                if ($product) {
                    // Prepare the SQL statement for updating the product
                    $stmt = $pdo->prepare("UPDATE product SET 
                    product_name = :name, 
                    description = :description, 
                    type = :type, 
                    price = :price, 
                    quantity = :quantity, 
                    image = :image 
                    WHERE product_id = :id");

                    // Default to the existing image if no new image is uploaded
                    $image = isset($_POST['existing_image']) ? $_POST['existing_image'] : $product['image'];

                    // Check if a new image is uploaded
                    if (!empty($_FILES['productImage']['name'])) {
                        // Generate the new image path within the 'img/' directory
                        $imagePath = 'img/' . basename($_FILES['productImage']['name']);

                        // Try to move the uploaded image to the desired directory (img/)
                        if (!move_uploaded_file($_FILES['productImage']['tmp_name'], $imagePath)) {
                            echo "Failed to upload image.";
                            exit;
                        }

                        // Update the image path to the new uploaded image
                        $image = $imagePath;
                    }

                    // Execute the statement to update the product in the database
                    $stmt->execute([
                        ':id' => $productId,
                        ':name' => $_POST['product_name'],
                        ':description' => $_POST['description'],
                        ':type' => $_POST['type'],
                        ':price' => $_POST['price'],
                        ':quantity' => $_POST['quantity'],
                        ':image' => $image, // Store the relative image path (e.g., 'img/filename')
                    ]);

                    echo "Product updated successfully!";
                    exit;
                } else {
                    echo "Product not found.";
                }
            } else {
                echo "Product ID is required.";
            }
        }
    }

    // Fetch all products
    $stmt = $pdo->query("SELECT * FROM product ORDER BY product_id");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
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
                <a href="Orders.php">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <span>Orders</span>
                </a>
            </div>
        </div>

        <div align="center">
            <a href="index.php" class="logout-btn">Log Out</a>
        </div>
    </div>
    <?php


    // Fetch the filter type from the URL, if set, or set to 'all' by default
    $filterType = isset($_GET['filterType']) ? $_GET['filterType'] : 'all';

    // Prepare SQL query based on the filter
    if ($filterType === 'all') {
        // Fetch all products if no filter is applied
        $stmt = $pdo->prepare("SELECT * FROM product");
    } else {
        // Fetch products by type
        $stmt = $pdo->prepare("SELECT * FROM product WHERE type = :type");
        $stmt->bindParam(':type', $filterType, PDO::PARAM_STR);
    }

    // Execute the query and fetch the products
    $stmt->execute();
    $products = $stmt->fetchAll();
    ?>
    <div class="main-content">
        <header>
            <h2>Admin Dashboard</h2>
            <div class="filter-bar">
                <label for="status-filter">Product Type:</label>
                <select id="status-filter">
                    <option value="all" <?= $filterType === 'all' ? 'selected' : '' ?>>All</option>
                    <option value="Tahini" <?= $filterType === 'Tahini' ? 'selected' : '' ?>>Tahini</option>
                    <option value="Halva" <?= $filterType === 'Halva' ? 'selected' : '' ?>>Halva</option>
                </select>
                <button class="btn-submit1" onclick="applyFilter()">Apply Filter</button>
            </div>
        </header>

        <script>
            function applyFilter() {
                const filterType = document.getElementById('status-filter').value;
                const url = new URL(window.location.href);
                url.searchParams.set('filterType', filterType); // Update the URL with the selected filter
                window.location.href = url.toString(); // Reload the page with the updated filter
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
                            <option value="Tahini">Tahini</option>
                            <option value="Halva">Halva</option>
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
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="productTable">
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['product_id']) ?></td>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= $product['image'] ?>" alt="Product Image" style="max-width: 80px;">
                            <?php else: ?>
                                <span>No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= htmlspecialchars($product['type']) ?></td>
                        <td><?= number_format($product['price'], 2) ?></td>
                        <td><?= intval($product['quantity']) ?></td>

                        <td>
                            <button class="btn-action btn-edit" onclick="editProduct(this.parentElement.parentElement, <?= $product['product_id'] ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action btn-delete" onclick="deleteProduct(<?= $product['product_id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

<script>
    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            const formData = new FormData();
            formData.append("action", "delete");
            formData.append("product_id", productId);

            // Send the delete request to the server
            fetch("", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Show the response message (Success or failure)
                    // Find the row by the product ID
                    const row = document.querySelector(`#product-${productId}`);
                    if (row) {
                        row.remove(); // Remove the row from the HTML table
                    }
                });
        }
    }
    function editProduct(row, productId) {
        const cells = row.querySelectorAll("td");
        const editableFields = ["product_name", "description", "type", "price", "quantity"];
        if (row.isEditing) {
            const formData = new FormData();
            formData.append("action", "edit");
            formData.append("product_id", productId);
            editableFields.forEach((field, index) => {
                const input = cells[index + 2].querySelector("input");
                if (input) {
                    formData.append(field, input.value);
                    cells[index + 2].innerText = input.value;
                }
            });
            fetch("", { method: "POST", body: formData })
                .then(res => res.text())
                .then(data => alert(data))
                .catch(err => console.error(err));
            row.isEditing = false;
        } else {
            editableFields.forEach((_, index) => {
                const value = cells[index + 2].innerText;
                cells[index + 2].innerHTML = `<input type='text' value='${value}' />`;
            });
            row.isEditing = true;
        }
    }

</script>
</body>
</html>
