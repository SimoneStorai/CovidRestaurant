<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");
    
    // Parse dish ID.
    if (!assert_int_array($_POST, "dish_id"))
    {
        echo("Invalid dish ID provided.");
        return;
    }
    $dish_id = intval($_POST["dish_id"]);

    // Parse ingredient ID.
    if (!assert_int_array($_POST, "ingredient_id"))
    {
        echo("Invalid ingredient ID provided.");
        return;
    }
    $ingredient_id = intval($_POST["ingredient_id"]);

    // Parse quantity
    if (!assert_int_array($_POST, "quantity"))
    {
        echo("Invalid quantity provided.");
        return;
    }
    $quantity = intval($_POST["quantity"]);

    // Prepare ingredient insert statement.
    $dish_ingredient_stmt = $db->prepare("INSERT INTO `dish_ingredient` (`dish_id`, `ingredient_id`, `quantity`) VALUES (?, ?, ?)");
    $dish_ingredient_stmt->bind_param("iii", $dish_id, $ingredient_id, $quantity);

    // Execute ingredient insert statement.
    $dish_ingredient_stmt->execute();

    echo("Ingredient added.");
?>