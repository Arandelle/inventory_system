<?php
session_start();
include 'database.php';

function getPaginationData($conn, $page, $itemsPerPage)
{
    $offset = ($page - 1) * $itemsPerPage;

    // Fetch paginated results
    $stmt = $conn->prepare("SELECT * FROM daily_consumption ORDER BY ConsumptionDate DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $itemsPerPage, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch total count for pagination
    $totalResults = $conn->query("SELECT COUNT(*) as total FROM daily_consumption")->fetch_assoc()['total'];
    $totalPages = ceil($totalResults / $itemsPerPage);

    return [$result, $totalPages];
}

function showMessage()
{
    if (isset($_SESSION['message'])) {
        $messageType = $_SESSION['messageType'] == 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white';
        echo "<p class='text-center p-2 $messageType'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message'], $_SESSION['messageType']);
    }
}

// Default page settings
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$itemsPerPage = 10; // Change this value as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = trim($_POST["name"] ?? '');
    $cost = floatval($_POST["cost"] ?? 0);
    $category = trim($_POST["category"] ?? '');
    $date = trim($_POST["date"] ?? '');
    $quan = intval($_POST["quan"] ?? 0);

    if ($name && $cost > 0 && $category && $date && $quan > 0) {
        $stmt = $conn->prepare("INSERT INTO daily_consumption (Name, Cost, Category, ConsumptionDate, Quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssi", $name, $cost, $category, $date, $quan);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Successfully Added!";
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
    header("Location: index.php?page=" . $page);
    exit();
}

// Fetch paginated data
list($result, $totalPages) = getPaginationData($conn, $page, $itemsPerPage);
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
        <?php include 'itemModal.php'; echo ItemModal(); ?>
    </div>

    <!-- Toolbar -->
    <?php include 'toolbar.php'; echo Toolbar(); ?>

    <!-- Message Display -->
    <?php showMessage(); ?>

    <!-- Table Body -->
    <div class="flex flex-col justify-center">
        <?php include 'tableBody.php'; echo Table($result, $page, $totalPages); ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
