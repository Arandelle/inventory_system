<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="p-4 bg-gray-200">

    <?php
    include 'toolbar.php';
    echo Toolbar();
    ?>
 <?php
 include 'tableBody.php';
 echo Table();
 ?>
</body>

<script>
    function AddNewConsumption() {
        const button = document.getElementById("add");
        button.innerHTML = "Clicked"
    }
</script>
</html>