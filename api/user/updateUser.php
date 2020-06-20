<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Get user ID.
    if (!assert_int_array($_POST, "id"))
    {
        echo("Invalid user ID provided.");
        return;
    }
    $id = $_POST["id"];

    // Parse mail.
    if (!assert_string_array($_POST, "mail", false))
    {
        echo("Invalid mail provided.");
        return;
    }
    $mail = $_POST["mail"];

    // Parse display name.
    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid name provided.");
        return;
    }
    $name = $_POST["name"];

    // Prepare and execute insert statement.
    $user_stmt = $db->prepare("
        UPDATE user SET 
        mail = ?, 
        name = ?
        WHERE id = ?");
    $user_stmt->bind_param("ssi", $mail, $name, $id);
    $user_stmt->execute();
?>