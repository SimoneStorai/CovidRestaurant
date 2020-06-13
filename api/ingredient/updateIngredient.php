<?php
    include("../api/config/db.php");
    include("../util/integer.php");
    include("../util/double.php");
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

    // Get ingredient ID.
    if (!assert_int_array($_POST, "id"))
    {
        echo("Invalid ingredient ID provided.");
        return;
    }
    $id = $_POST["id"];

    // Parse new name.
    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid ingredient name provided.");
        return;
    }
    $name = $_POST["name"];

    // Parse new quantity.
    if (!assert_int_array($_POST, "quantity", false))
    {
        echo("Invalid ingredient quantity provided.");
        return;
    }
    $quantity = intval($_POST["quantity"]);

    // Prepare ingredient update statement.
    $ingredient_stmt = $db->prepare(
        "UPDATE `ingredient` SET 
        `name` = ?,
        `quantity` = ?
        WHERE `id` = ?");
    $ingredient_stmt->bind_param(
        "sii", 
        $name, 
        $quantity, 
        $id);

    // Execute ingredient update statement.
    $ingredient_stmt->execute();
?>