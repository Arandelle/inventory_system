<?php
session_start(); // Start session to store messages
include '../database.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['Name'] ?? "Record";
    $uppercase = ucwords($name);

    if ($id) {
        // Prepare the delete query
        $stmt = $conn->prepare("DELETE FROM item_details WHERE ID = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "$uppercase successfully deleted!";
            $_SESSION['messageType'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['messageType'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Invalid ID.";
        $_SESSION['messageType'] = "error";
    }

    $conn->close();

    // Redirect back to the table page
    header("Location: ../index.php");
    exit();
} else {
    // Invalid access
    header("Location: ../index.php");
    exit();
}
