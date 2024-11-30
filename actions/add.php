<?php 
session_start();
include '../database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = trim($_POST["name"] ?? '');
    $cost = floatval($_POST["cost"] ?? 0);
    $category = trim($_POST["category"] ?? '');
    $date = trim($_POST["date"] ?? '');
    $quan = intval($_POST["quan"] ?? 0);
    $totalCost = $cost * $quan;

    if ($name && $cost > 0 && $category && $date && $quan > 0) {
        $stmt = $conn->prepare("INSERT INTO daily_consumption (Name, Cost, Category, ConsumptionDate, Quantity, total_cost) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssii", $name, $cost, $category, $date, $quan, $totalCost);

        if ($stmt->execute()) {
            $_SESSION['message'] = "$name Successfully Added!";
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