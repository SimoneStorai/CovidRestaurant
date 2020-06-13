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

    // Prepare ingredient insert statement.
    $ingredient_stmt = $db->prepare("INSERT INTO `ingredient` (`name`, `quantity`) VALUES (?, ?)");
    $ingredient_stmt->bind_param("sd", $name, $quantity);

    // Decode JSON ingredient data.
    $ingredient = json_decode($_POST["ingredient"]);

    if (!assert_string_array($ingredient, "name", false))
    {
        echo("Invalid ingredient name.")
        return;
    }
    $name = $ingredient["name"];

    if (!assert_int_array($ingredient, "quantity"))
    {
        echo("Invalid ingredient initial quantity.");
        return;
    }
    $quantity = $ingredient["quantity"]

    // Execute ingredient insert statement.
    $ingredient_stmt->execute();
?>