<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Prepare ingredient insert statement.
    $ingredient_stmt = $db->prepare("INSERT INTO `ingredient` (`name`, `quantity`) VALUES (?, ?)");
    $ingredient_stmt->bind_param("sd", $name, $quantity);

    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid ingredient name.");
        return;
    }
    $name = $_POST["name"];

    if (!assert_int_array($_POST, "quantity"))
    {
        echo("Invalid ingredient initial quantity.");
        return;
    }
    $quantity = $_POST["quantity"];

    // Execute ingredient insert statement.
    $ingredient_stmt->execute();
?>