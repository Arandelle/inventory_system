<?php
session_start(); // Start session to store messages

include 'database.php';
$message = "";
$messageType = "";

// Set default page for pagination
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$itemsPerPage = 4; // Example number of items per page
$offset = ($page - 1) * $itemsPerPage;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST["name"] ?? '';
    $cost = $_POST["cost"] ?? 0;
    $category = $_POST["category"] ?? '';
    $date = $_POST["date"] ?? '';
    $quan = $_POST["quan"] ?? 0;

    if ($name && $cost && $category && $date && $quan) {
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO daily_consumption (Name, Cost, Category, ConsumptionDate, Quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsss", $name, $cost, $category, $date, $quan);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Successfully Added!";
            $_SESSION['messageType'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $stmt->error;
            $_SESSION['messageType'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Please fill all fields!";
        $_SESSION['messageType'] = "error";
    }
    $conn->close();

    // Redirect after form submission
    header("Location: index.php" . "?page=" . $page); // Maintain current page for pagination
    exit();
}

// Fetch data from the database for display (using LIMIT and OFFSET for pagination)
$sql = "SELECT * FROM daily_consumption ORDER BY ConsumptionDate DESC LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

// Get total count for pagination
$totalResults = $conn->query("SELECT COUNT(*) FROM daily_consumption")->fetch_row()[0];
$totalPages = ceil($totalResults / $itemsPerPage);

?>

<!DOCTYPE html>
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
    
    <div id="itemModal" class="hidden">
        <?php include 'itemModal.php';
        echo ItemModal() ?>
    </div>

    <!-- Toolbar -->
    <?php
    include 'toolbar.php';
    echo Toolbar();
    ?>

    <!-- Message Display -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p class='text-center p-2 " . ($_SESSION['messageType'] == 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white') . "'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
        unset($_SESSION['messageType']);
    }
    ?>

    <!-- Table Body -->
    <?php include 'tableBody.php';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $items_per_page = 10; // Set the number of items per page
    echo Table($page, $items_per_page);
    ?>


</body>
</html>

<?php
$conn->close();
?>
