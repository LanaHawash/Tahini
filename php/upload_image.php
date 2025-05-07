<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadDirectory = 'uploads/';
    $uploadFile = $uploadDirectory . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // Return the uploaded image path to be saved in the database
        echo json_encode(['imagePath' => $uploadFile]);
    } else {
        echo json_encode(['error' => 'Failed to upload image']);
    }
}
?>
