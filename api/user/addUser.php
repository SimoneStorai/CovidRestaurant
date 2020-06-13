<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Parse mail.
    if (!assert_string_array($_POST, "mail", false))
    {
        echo("Invalid mail provided.");
        return;
    }
    $mail = $_POST["mail"];

    // Parse plain-text password.
    if (!assert_string_array($_POST, "password", false))
    {
        echo("Invalid password provided.");
        return;
    }
    $password = $_POST["password"];

    // Parse display name.
    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid name provided.");
        return;
    }
    $name = $_POST["name"];

    // Prepare and execute insert statement.
    $user_stmt = $db->prepare("INSERT INTO user (mail, password, name) VALUES(?, ?, ?)");
    $user_stmt->bind_param("sss", $mail, $password, $name);
    $user_stmt->execute();
?>