<?php
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "database.php";
    $name = $_POST["name"] ?? null;
    $cost = $_POST["cost"] ?? null;
    $category = $_POST["category"] ?? null;
    $date = $_POST["date"] ?? null;
    $quan = $_POST["quan"] ?? null;

    if ($name && $cost && $category && $date && $quan) {
        $stmt = $conn->prepare("INSERT INTO daily_consumption (Name, Cost, Category, ConsumptionDate, Quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $name, $cost, $category, $date, $quan);
        if ($stmt->execute()) {
            $message = "Successfully Added!";
            $messageType = "success";
            echo "<script>reloadTable();</script>";
        } else {
            $message = "Error" . $stmt->error;
            $messageType = "error";
        }
        $stmt->close();
    } else {
        $message = "All fiels are required";
        $messageType = "error";
    }
    $conn->close();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="script.js"></script>
    <title>Consumption Tracker</title>
</head>
<body class="p-4 bg-gray-200">

    <?php
    include 'toolbar.php';
    echo Toolbar();
    ?>
 <?php
 include 'tableBody.php';
 echo Table($message,$messageType);
 ?>
    <?php
    include 'tablePagination.php';
    echo Pagination();
    ?>
</body>

<script>
    function AddNewConsumption() {
        const button = document.getElementById("add");
        button.innerHTML = "Clicked"
    }
</script>
</html>