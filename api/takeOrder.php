<?php
    include("../api/config/db.php");
    include("../util/integer.php");
    include("../util/double.php");
    include("../util/string.php");

    // Parse table ID.
    if (!assert_int_array($_POST, "table_id"))
    {
        echo("Invalid table ID.");
        return;
    }
    $table_id = intval($_POST["table_id"]);

    // Parse orders array.
    if (!isset($_POST["orders"]))
    {
        echo("Invalid orders.");
        return;
    }
    $orders = $_POST["orders"];

    // Get current datetime in a MySQL compatible format.
    $timestamp = date('Y-m-d H:i:s');

    // Prepare order insert statement.
    $order_stmt = $db->prepare("INSERT INTO `order` (`table_id`, `timestamp`) VALUES (?, ?)");
    $order_stmt->bind_param("is", $table_id, $timestamp);

    // Execute order insert statement.
    // Get its ID (last inserted).
    $order_stmt->execute();
    $order_id = $db->insert_id;

    // Prepare order-dish insert statement.
    $order_dish_stmt = $db->prepare("INSERT INTO `order_dish` (`order_id`, `dish_id`, `quantity`) VALUES (?, ?, ?)");
    $order_dish_stmt->bind_param("iii", $order_id, $dish_id, $quantity);

    echo(count($orders));
    foreach ($orders as $order)
    {
        // Parse dish ID.
        if (!assert_int_array($order, "id"))
        {
            echo("Invalid dish ID provided.");
            return;
        }
        $dish_id = intval($order["id"]);

        // Parse quantity.
        if (!assert_int_array($order, "quantity"))
        {
            echo("Invalid quantity provided.");
            return;
        }
        $quantity = intval($order["quantity"]);
        
        // Execute order dish statement.
        $order_dish_stmt->execute();
    }

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