<?php 
session_start();
include '../database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $title = trim($_POST["title"] ?? '');
    $price = floatval($_POST["price"] ?? 0);
    $category = trim($_POST["category"] ?? '');
    $quantity = intval($_POST["quantity"] ?? 0);


    if ($title && $price > 0 && $category && $quantity > 0) {
        $stmt = $conn->prepare("INSERT INTO item_details (Title, Price, Category, Quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdsi", $title, $price, $category, $quantity);

        if ($stmt->execute()) {
            $_SESSION['message'] = "$title Successfully Added!";
            $_SESSION['messageType'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['messageType'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Please fill all fields with valid data!";
        $_SESSION['messageType'] = "error";
    }

    // Redirect to maintain current page
    header("Location: ../index.php?page=" . $page);
    exit();
}

?>