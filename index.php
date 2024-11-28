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
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$itemsPerPage = 10; // Change this value as needed

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
<body class="p-4 bg-gray-200 flex flex-col justify-between h-screen">
 <div>
        <div id="addModal" class="hidden">
            <?php include 'addForm.php';
            echo addForm(); ?>
        </div>

        <div id="editModal" class="hidden">
            <?php include 'editForm.php';
            echo editForm(); ?>
        </div>
    
        <!-- Toolbar -->
        <?php include 'toolbar.php';
        echo Toolbar(); ?>
    
        <!-- Message Display -->
        <?php showMessage(); ?>
    
        <!-- Table Body -->
        <div class="flex flex-col justify-center">
            <?php include 'tableBody.php';
            echo Table($result, $page, $totalPages); ?>
        </div>
    
 </div>
    <p class="text-gray-500 text-center">@arandellepaguinto</p>
</body>
</html>

<?php $conn->close(); ?>
