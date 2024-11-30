<?php
session_start();
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateData'])) { 
    // Retrieve and sanitize form inputs
    $id = intval($_POST['id'] ?? 0); // Hidden ID field
    $new_name = trim($_POST["name"] ?? '');
    $new_cost = floatval($_POST["cost"] ?? 0);
    $new_category = trim($_POST["category"] ?? '');
    $new_date = trim($_POST["date"] ?? '');
    $new_quan = intval($_POST["quan"] ?? 0);
    $newTotal_cost = floatval($new_cost * $new_quan);

    // Validate inputs
    if ($id > 0 && $new_name && $new_cost > 0 && $new_category && $new_date && $new_quan > 0) {
        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare("UPDATE daily_consumption 
                SET name = ?, Cost = ?, Category = ?, ConsumptionDate = ?, Quantity = ?, total_cost = ?
                WHERE ID = ?
            ");

            // Bind parameters and execute the query
            $stmt->bind_param("sdssiii", $new_name, $new_cost, $new_category, $new_date, $new_quan,$newTotal_cost, $id);

            if ($stmt->execute()) {
                // Redirect on success
                $_SESSION["message"] = "$new_name Successfully updated";
                $_SESSION["messageType"] = "success";
                header("Location: ../index.php?success=1");
                exit;
            } else {
                // Handle failure
                    $_SESSION["message"] = "Error: " . $stmt->error;
                    $_SESSION["messageType"] = "error";
                header("Location: ../index.php?error=Update failed");
                exit;
            }
        } catch (Exception $e) {
            // Handle exception
            header("Location: ../index.php?error=" . urlencode($e->getMessage()));
            exit;
        }
    } else {
        // Redirect back if validation fails
        $_SESSION["message"] = "Please fill up all input fields";
        $_SESSION["messageType"] = "error";
        header("Location: ../index.php?error=Invalid input data");
        exit;
    }
}
