<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ITEC116_LAB";

    $conn = new mysqli($serverName, $username, $password,  $dbname);

    if ($conn->connect_error) {
        die("Connection failed". $conn->connect_error);
    }

?>