<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cunsumption_tracker";

    $conn = new mysqli($serverName, $username, $password,  $dbname);

    if ($conn->connect_error) {
        die("Connection failed". $conn->connect_error);
    }

?>