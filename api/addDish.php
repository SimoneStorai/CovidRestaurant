<?php
    include("../api/config/db.php");
    include("../util/string.php");

    // Prepare dish insert statement.
    // Return last inserted ID.
    $dish_stmt = $db->prepare("INSERT INTO `dish` (`name`, `price`, `waiting_time`, `image`) VALUES (?, ?, ?)");
    $dish_stmt->bind_param("sis", $name, $waiting_time, $image);

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

    // Decode JSON dish data.
    $dish = json_decode($_POST["dish"]);

    $name = $dish["name"];
    if (!is_string($name) || strlen($name) == 0) return;

    $price = $dish["price"];

    $waiting_time = $dish["waiting_time"];
    if (!is_int($waiting_time) || $waiting_time < 0) return;

    $image = $dish["image"];
    if (!is_string($image) || strlen($image) == 0) $image = "";

    // Execute dish insert statement, select its entry's ID.
    // Return last inserted ID.
    $dish_stmt->execute();
    $dish_id = $db->insert_id;

    // Prepare dish_ingredient insert statement.
    $dish_ingredient_stmt = $db->prepare("INSERT INTO `dish_ingredient` (`ingredient_id`, `quantity`) VALUES (?, ?, ?);");
    $dish_ingredient_stmt->bind_param($dish_id, $id, $quantity);
    
    // Register ingredients.
    $ingredients = $dish["ingredients"];
    if (is_array($ingredients))
    {
        foreach ($ingredients as $ingredient)
        {
            if (is_array($ingredient))
            {
                // Parse and assert ingredient ID.
                $id = $ingredient["id"];
                if (!is_int($id) || $id < 0) continue;

                // Parse and assert ingredient quantity.
                $quantity = $ingredient["quantity"];
                if (!is_int($quantity) || $quantity < 0) continue;

                // Execute statement.
                $dish_ingredient_stmt->execute();
            }
        }
    }
?>