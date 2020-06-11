<?php
    include("../api/config/db.php");
    include("../util/integer.php");
    include("../util/double.php");
    include("../util/string.php");

    // Parse name.
    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid dish name provided.");
        return;
    }
    $name = $_POST["name"];

    // Parse price.
    if (!assert_double_array($_POST, "price"))
    {
        echo("Invalid dish price provided.");
        return;
    }
    $price = doubleval($_POST["price"]);

    // Parse waiting time.
    if (!assert_string_array($_POST, "waiting_time", false))
    {
        echo("Invalid waiting_time provided.");
        return;
    }
    $waiting_time = $_POST["waiting_time"];

    // Parse description.
    if (!assert_string_array($_POST, "description", false))
    {
        echo("Invalid description provided.");
        return;
    }
    $description = $_POST["description"];

    // Parse image URL.
    if (!assert_string_array($_POST, "image_url", false))
    {
        echo("Invalid image URL provided.");
        return;
    }
    $image_url = $_POST["image_url"];

    // Prepare dish insert statement.
    $dish_stmt = $db->prepare("INSERT INTO `dish` (`name`, `price`, `waiting_time`, `description`, `image_url`) VALUES (?, ?, ?, ?, ?)");
    $dish_stmt->bind_param("sdsss", $name, $price, $waiting_time, $description, $image_url);

    // Execute dish insert statement.
    $dish_stmt->execute();

    // Echo last inserted ID as JSON.
    header("Content-Type: application/json");
    echo(json_encode(array($dish_stmt->insert_id)));

    /*
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
    */
?>