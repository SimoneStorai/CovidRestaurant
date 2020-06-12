<?php
    include("../api/config/db.php");
    include("../util/integer.php");
    include("../util/string.php");

    // Get dish ID.
    if (!assert_int_array($_POST, "dish_id"))
    {
        echo("Invalid dish ID provided.");
        return;
    }
    $dish_id = $_POST["dish_id"];

    // Get ingredient ID.
    if (!assert_int_array($_POST, "ingredient_id"))
    {
        echo("Invalid ingredient ID provided.");
        return;
    }
    $ingredient_id = $_POST["ingredient_id"];

    // Prepare dish delete statement.
    $dish_ingredient_stmt = $db->prepare("DELETE FROM `dish_ingredient` WHERE `dish_id` = ? AND `ingredient_id` = ?");
    $dish_ingredient_stmt->bind_param("ii", $dish_id, $ingredient_id);

    // Execute dish remove statement.
    $dish_ingredient_stmt->execute();
?>