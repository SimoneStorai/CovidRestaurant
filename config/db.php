<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    // Init new MySQL connection.
    $db = new mysqli($servername, $username, $password);

    // Assert connection status.
    if ($db->connect_error) 
        die("Connection has failed: " . $db->connect_error . ".");
    echo "Connected successfully.";
?>