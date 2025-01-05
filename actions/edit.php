<?php 
session_start();
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateData'])) {
    // Retrieve and sanitize form inputs
    $id = intval($_POST['id'] ?? 0); // Hidden ID field
    $new_title = trim($_POST["title"] ?? '');
    $new_price = floatval($_POST["price"] ?? 0);
    $new_category = trim($_POST["category"] ?? '');
    $new_quan = intval($_POST["quantity"] ?? 0);
    $new_size = trim($_POST["size"] ?? '');
    $new_color = trim($_POST["color"] ?? '');
    $new_description = trim($_POST["description"] ?? '');

    $imageData = null; // Default: No image uploaded
    $updateImage = false; // Flag to check if the image should be updated

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
            $updateImage = true; // Set the flag to update the image
        }
    }

    // Validate inputs
    if ($id > 0 && $new_title && $new_price > 0 && $new_category && $new_quan >= 0 && $new_size && $new_color && $new_description) {
        try {
            // Prepare the SQL statement
            if ($updateImage) {
                // Update all fields including the image
                $stmt = $conn->prepare(
                    "UPDATE item_details
                     SET Title = ?, Price = ?, Category = ?, Quantity = ?, Size = ?, Color = ?, Description = ?, Image = ?
                     WHERE ID = ?"
                );
                // Bind parameters
                $stmt->bind_param("sdsissssi", $new_title, $new_price, $new_category, $new_quan, $new_size, $new_color, $new_description, $imageData, $id);
            } else {
                // Update fields except the image
                $stmt = $conn->prepare(
                    "UPDATE item_details
                     SET Title = ?, Price = ?, Category = ?, Quantity = ?, Size = ?, Color = ?, Description = ?
                     WHERE ID = ?"
                );
                // Bind parameters
                $stmt->bind_param("sdsisssi", $new_title, $new_price, $new_category, $new_quan, $new_size, $new_color, $new_description, $id);
            }

            // Execute the query
            if ($stmt->execute()) {
                $_SESSION["message"] = "$new_title successfully updated!";
                $_SESSION["messageType"] = "success";
                header("Location: ../index.php");
                exit;
            } else {
                // Handle query execution failure
                $_SESSION["message"] = "Database error: " . $stmt->error;
                $_SESSION["messageType"] = "error";
                header("Location: ../index.php");
                exit;
            }
        } catch (Exception $e) {
            // Log and handle exception
            error_log("Error updating item: " . $e->getMessage());
            $_SESSION["message"] = "Unexpected error: " . $e->getMessage();
            $_SESSION["messageType"] = "error";
            header("Location: ../index.php");
            exit;
        }
    } else {
        // Redirect back if validation fails
        $_SESSION["message"] = "Please fill all fields with valid data.";
        $_SESSION["messageType"] = "error";
        header("Location: ../index.php");
        exit;
    }
}
?>
