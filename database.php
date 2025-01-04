<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory_system";

    $conn = new mysqli($serverName, $username, $password,  $dbname);

    if ($conn->connect_error) {
        die("Connection failed". $conn->connect_error);
    }

?>