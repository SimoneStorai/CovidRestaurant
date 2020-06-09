<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

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

    // Prepare order_dish insert statement.
    $order_dish_stmt = $db->prepare("INSERT INTO `order_dish` (`order_id`, `dish_id`, `quantity`) VALUES (?, ?, ?);");
    $order_dish_stmt->bind_param($order_id, $id, $quantity);

    // Add dishes.
    $dishes = $order["dishes"];
    if (is_array($dishes))
    {
        foreach ($dishes as $dish)
        {
            if (is_array($dish))
            {
                // Parse and assert dish ID.
                $id = $dish["dish_id"];
                if (!is_int($id) || $id < 0) continue;

                // Parse and assert dish quantity.
                $quantity = $dish["quantity"];
                if (!is_int($quantity) || $quantity < 0) continue;

                // Execute statement.
                $order_dish_stmt->execute();
            }
        }
    }
?>