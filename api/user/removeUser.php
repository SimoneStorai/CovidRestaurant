<?php
    include("../config/db.php");
    include("../util/integer.php");
    include("../util/string.php");

    // Get user ID.
    if (!assert_int_array($_POST, "id"))
    {
        echo("Invalid user ID provided.");
        return;
    }
    $id = $_POST["id"];

    // Prepare user delete statement.
    $user_stmt = $db->prepare("DELETE FROM `user` WHERE `id` = ?");
    $user_stmt->bind_param("i", $id);

    // Execute user remove statement.
    $user_stmt->execute();
?>