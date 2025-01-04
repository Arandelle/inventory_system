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

    // Validate inputs
    if ($id > 0 && $new_title && $new_price > 0 && $new_category && $new_quan >= 0) {
        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare(
                "UPDATE item_details
                 SET Title = ?, Price = ?, Category = ?, Quantity = ?
                 WHERE ID = ?"
            );

            // Bind parameters
            $stmt->bind_param("sdsii", $new_title, $new_price, $new_category, $new_quan, $id);

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
