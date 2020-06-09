<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Decode authorization credentials.
    if (!assert_string_array($_POST["mail"], false))
    {
        echo("Invalid mail.");
        return;
    }
    $mail = $_POST["mail"];

    if (!assert_string_array($_POST["password"], false))
    {
        echo("Invalid password");
        return;
    }
    $password = $_POST["password"];

    // Parse result.
    $result = $dishes_stmt->query();
    echo($result);
?>