<?php
    include("../config/db.php");
    include("../util/integer.php");
    include("../util/string.php");

    /*
    // Decode authorization credentials.
    if (!assert_string_array($_POST, "mail", false))
    {
        echo("Invalid mail.");
        return;
    }
    $mail = $_POST["mail"];

    if (!assert_string_array($_POST, "password", false))
    {
        echo("Invalid password");
        return;
    }
    $password = $_POST["password"];
    */

    // Get dish ID.
    if (!assert_int_array($_POST, "dish_id"))
    {
        echo("Invalid dish ID provided.");
        return;
    }
    $dish_id = $_POST["dish_id"];

    // Prepare dish delete statement.
    $dish_stmt = $db->prepare("DELETE FROM dish WHERE id = ?");
    $dish_stmt->bind_param("i", $dish_id);

    // Execute dish remove statement.
    $dish_stmt->execute();
?>