<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['message']) ) {
    $to = "zina.marhiv@gmail.com"; // Multiple recipients
    $message = $_POST['message'];
    $subject = "Notification ". " , Email: " . $_POST['email'];
    $headers = "From: " . $_POST['email'];

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Notification sent successfully!'); window.history.back();</script>";
    } else {
        echo "<script>alert('Failed to send notification.'); window.history.back();</script>";
    }
} else {
    echo "All fields are required.";
}
?>
