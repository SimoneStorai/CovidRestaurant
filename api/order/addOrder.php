<?php
    include("../api/config/db.php");
    include("../util/integer.php");
    include("../util/string.php");

    // Prepare order insert statement.
    $order_stmt = $db->prepare("INSERT INTO `order` (`table_id`, `timestamp`) VALUES (?, ?)");
    $order_stmt->bind_param("is", $table_id, $timestamp);

    // Decode JSON order data.
    $order = json_decode($_POST["order"]);

    // Parse table ID.
    if (!assert_int_array($order, "table_id"))
    {
        echo("Invalid table ID.");
        return;
    }
    $table_id = $order["table_id"];

    // Get current date in a SQL-compatible format.
    $timestamp = date('Y-m-d H:i:s');

    // Execute custom insert statement.
    // Select the new order's primary ID.
    $order_stmt->execute();
    $order_id = $db->last_insert_id;

    // Prepare get dish availability select statement.
    $availability_stmt = $db->prepare(
        "SELECT COALESCE(MIN(FLOOR(i.quantity / di.quantity)), 0) AS units FROM dish_ingredient di
        JOIN ingredient i ON di.ingredient_id = i.id
        WHERE di.dish_id = ?;");
    $availability_stmt->bind_param("i", $dish_id);

    // Prepare order_dish insert statement.
    $order_dish_stmt = $db->prepare("INSERT INTO order_dish (order_id, dish_id, quantity) VALUES (?, ?, ?)");
    $order_dish_stmt->bind_param("iii", $order_id, $id, $quantity);

    // Prepare ingredient consumption update statement.
    $ingredient_consumption_stmt = $db->prepare("
        UPDATE ingredient i JOIN dish_ingredient di ON di.ingredient_id = i.id
        SET i.quantity = (i.quantity - di.quantity) 
        WHERE di.dish_id = ?;");
    $ingredient_consumption_stmt->bind_param("i", $dish_id)

    // Add dishes.
    $dishes = $order["dishes"];
    if (is_array($dishes))
    {
        foreach ($dishes as $dish)
        {
            if (is_array($dish))
            {
                // Parse and assert dish ID.
                $dish_id = $dish["dish_id"];
                if (!is_int($id) || $id < 0) continue;

                // Parse and assert dish quantity.
                $quantity = $dish["quantity"];
                if (!is_int($quantity) || $quantity < 0) continue;

                // Assert if the stock quantity requirement is met.
                $availability_stmt->execute();
                $result = $availability_stmt->get_result();
                if ($result->fetch_assoc["units"] > $quantity)
                {
                    // Execute insert order statement.
                    $order_dish_stmt->execute();

                    // Execute ingredient consumption statement.
                    $ingredient_consumption_stmt->execute();
                }
                else echo("Not enough ingredients.");
            }
            else echo()
        }
    }
?>