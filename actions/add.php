<?php 
session_start();
include '../database.php';

$page = $_GET['page'] ?? ''; // Ensure $page is defined

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $title = trim($_POST["title"] ?? '');
    $price = floatval($_POST["price"] ?? 0);
    $category = trim($_POST["category"] ?? '');
    $quantity = intval($_POST["quantity"] ?? 0);

    // Handle the uploaded image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Specify allowed image types
        $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        $fileType = $_FILES["image"]["type"];
        $fileSize = $_FILES["image"]["size"];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['message'] = "Invalid file type. Only images are allowed.";
            $_SESSION['messageType'] = "error";
        } elseif ($fileSize > $maxSize) {
            $_SESSION['message'] = "File size exceeds the maximum limit of 5MB.";
            $_SESSION['messageType'] = "error";
        } else {
            // Get the binary data of the image
            $imageData = file_get_contents($_FILES["image"]["tmp_name"]);
        }
    } else {
        $imageData = null; // No image uploaded
    }

    if ($title && $price > 0 && $category && $quantity > 0) {
        // Include the image data when inserting into the database
        $stmt = $conn->prepare("INSERT INTO item_details (Title, Price, Category, Quantity, Image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsis", $title, $price, $category, $quantity, $imageData);

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
