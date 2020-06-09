<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "covid_restaurant";

    // Init new MySQL connection.
    $db = new mysqli($hostname, $username, $password, $database);

    // Assert connection status.
    if ($db->connect_error) 
        die("Connection has failed: " . $db->connect_error . ".");
    echo "Connected successfully.";
?>