<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateData'])) { 
    // Retrieve and sanitize form inputs
    $id = intval($_POST['id'] ?? 0); // Hidden ID field
    $new_name = trim($_POST["name"] ?? '');
    $new_cost = floatval($_POST["cost"] ?? 0);
    $new_category = trim($_POST["category"] ?? '');
    $new_date = trim($_POST["date"] ?? '');
    $new_quan = intval($_POST["quan"] ?? 0);

    // Validate inputs
    if ($id > 0 && $new_name && $new_cost > 0 && $new_category && $new_date && $new_quan > 0) {
        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare("UPDATE daily_consumption 
                SET name = ?, Cost = ?, Category = ?, ConsumptionDate = ?, Quantity = ? 
                WHERE ID = ?
            ");

            // Bind parameters and execute the query
            $stmt->bind_param("sdssii", $new_name, $new_cost, $new_category, $new_date, $new_quan, $id);

            if ($stmt->execute()) {
                // Redirect on success
                header("Location: ../index.php?success=1");
                exit;
            } else {
                // Handle failure
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
        header("Location: ../index.php?error=Invalid input data");
        exit;
    }
}
