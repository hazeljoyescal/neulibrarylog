<?php
include 'db.php';

if (isset($_POST['purpose'])) {
    $user_id = $_POST['user_id'];
    $purpose = $_POST['purpose'];

    // Insert log with current date and time
    $sql = "INSERT INTO logs (user_id, purpose, visit_date) VALUES ('$user_id', '$purpose', NOW())";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to home with a success message
        header("Location: index.php?status=success");
    }
}
