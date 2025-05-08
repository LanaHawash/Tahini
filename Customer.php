<?php
session_start();

// Database connection settings
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

// Edit user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':id' => $user_id
        ]);
        echo "User updated successfully.";
    } catch (PDOException $e) {
        echo "Error updating user: " . $e->getMessage();
    }
    exit;
}

// Fetch all customers
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
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
                <img class="dd" src="img/KIG5.png" alt="Profile Image">
            </div>
        </div>
        <div class="sidebar-menu">
            <div class="menu-item"><a href="Admin.php"><i class="fas fa-home"></i><span>Home</span></a></div>
            <div class="menu-item"><a href="Productsad.php"><i class="fa-solid fa-bowl-food"></i><span>Products</span></a></div>
            <div class="menu-item"><a href="#" class="activeM"><i class="fa-solid fa-user-group"></i><span>Customers</span></a></div>
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

        <!-- Customer Table -->
        <div class="customers-list">
            <h3>Customers List</h3>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($customers) > 0) {
                    foreach ($customers as $customer) {
                        echo "<tr id='customer-row-{$customer['id']}'>";
                        echo "<td>{$customer['id']}</td>";
                        echo "<td>{$customer['name']}</td>";
                        echo "<td>{$customer['email']}</td>";
                        echo "<td>{$customer['phone']}</td>";
                        echo "<td>{$customer['address']}</td>";
                        echo "<td>{$customer['created_at']}</td>";
                        echo "<td>
                                    <button class='btn btn-edit' onclick=\"editCustomer({$customer['id']})\"><i class='fas fa-edit'></i></button>
                                    <button class='btn btn-email' onclick=\"fillEmailField('{$customer['email']}')\"><i class='fas fa-envelope'></i></button>
                                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No customers found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="send-notifications">
            <h3>Send Notifications</h3>
            <form id="notification-form" onsubmit="sendNotification(event);">
                <div class="form-group">
                    <label for="notification-email">Recipient Email</label>
                    <input type="email" id="notification-email" name="email" placeholder="Click on a customer to select their email" required>
                </div>
                <div class="form-group">
                    <label for="notification-message">Message</label>
                    <textarea id="notification-message" name="message" placeholder="Type your message here..." required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Notification</button>
            </form>
        </div>



        <script>
    // Edit customer
    function editCustomer(customerId) {
        const row = document.getElementById(`customer-row-${customerId}`);
        const cells = row.querySelectorAll("td");
        const editableFields = ["name", "email", "phone", "address"];
        const formData = new FormData();

        if (row.isEditing) {
            editableFields.forEach((field, index) => {
                const cell = cells[index + 1]; // Skip the ID column
                const inputValue = cell.querySelector("input").value; // Get input value
                cell.innerText = inputValue; // Update text in the cell
                formData.append(field, inputValue); // Add the updated value to FormData
            });

            formData.append("action", "edit");
            formData.append("user_id", customerId);

            fetch("", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.text())
                .then((data) => {
                    alert(data);
                    row.isEditing = false; // Toggle the editing state off
                })
                .catch((error) => console.error("Error:", error));
        } else {
            editableFields.forEach((field, index) => {
                const cell = cells[index + 1]; // Skip the ID column
                const value = cell.innerText;
                cell.innerHTML = `<input type="text" value="${value}" />`; // Make cell editable
            });

            row.isEditing = true; // Toggle the editing state on
        }
    }

    // Delete customer
    /*
    function deleteCustomer(customerId) {
        if (confirm("Are you sure you want to delete this customer?")) {
            const formData = new FormData();
            formData.append("action", "delete");
            formData.append("user_id", customerId);

            fetch("", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.text())
                .then((data) => {
                    alert(data);
                    location.reload();
                })
                .catch((error) => console.error("Error:", error));
        }
    }*/

    // Fill email field with customer's email when clicked
    // Fill email field with customer's email when clicked
    // عند النقر على عميل، يتم تعيين بريده الإلكتروني في الحقل الخاص
    // Function to fill the email field when clicking on a customer
    function fillEmailField(email) {
        document.getElementById('notification-email').value = email;
        alert(`Email field filled with: ${email}`);
        document.querySelector('.send-notifications').scrollIntoView({ behavior: 'smooth' });
    }

    // Send the notification via fetch
    function sendNotification(event) {
        event.preventDefault(); // Prevent form submission

        const email = document.getElementById('notification-email').value;
        const message = document.getElementById('notification-message').value;

        if (!email) {
            alert('Please select a customer by clicking on their row.');
            return;
        }

        if (message.trim() === '') {
            alert('Please write a message before sending.');
            return;
        }

        // Prepare the data to be sent via POST
        const formData = new FormData();
        formData.append('email', email);
        formData.append('message', message);

        // Send the request via fetch to the PHP script
        fetch('php/email.php', {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                alert(data); // Show the response from the server
                // Reset the fields after sending
                document.getElementById('notification-email').value = '';
                document.getElementById('notification-message').value = '';
            })
            .catch((error) => {
                alert('Error sending the message. Please try again.');
                console.error('Error:', error);
            });
    }


        </script>
</body>
</html>
