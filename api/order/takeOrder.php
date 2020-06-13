<?php
    include("../config/db.php");
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

    // Prepare get dish availability select statement.
    $availability_stmt = $db->prepare(
        "SELECT COALESCE(MIN(FLOOR(i.quantity / di.quantity)), 0) AS units FROM dish_ingredient di
        JOIN ingredient i ON di.ingredient_id = i.id
        WHERE di.dish_id = ?;");
    $availability_stmt->bind_param("i", $dish_id);

    // Prepare order-dish insert statement.
    $order_dish_stmt = $db->prepare("INSERT INTO `order_dish` (`order_id`, `dish_id`, `quantity`) VALUES (?, ?, ?)");
    $order_dish_stmt->bind_param("iii", $order_id, $dish_id, $quantity);

    // Prepare ingredient consumption update statement.
    $ingredient_consumption_stmt = $db->prepare("
        UPDATE ingredient i JOIN dish_ingredient di ON di.ingredient_id = i.id
        SET i.quantity = (i.quantity - di.quantity) 
        WHERE di.dish_id = ?;");
    $ingredient_consumption_stmt->bind_param("i", $dish_id);

    foreach ($orders as $order)
    {
        // Parse dish ID.
        if (!assert_int_array($order, "id"))
        {
            echo("Invalid dish ID provided.");
            return;
        }
        $dish_id = intval($order["id"]);

        // Execute availability statement.
        $availability_stmt->execute();
        $result = $availability_stmt->get_result();
        if ((!$row = $result->fetch_assoc()) 
            || 
            ($row["units"] <= 0))
        {
            echo($dish_id . " is unavailable.");
            continue;
        }

        // Parse quantity.
        if (!assert_int_array($order, "quantity"))
        {
            echo("Invalid quantity provided.");
            return;
        }
        $quantity = intval($order["quantity"]);
        
        // Execute order dish and ingredient consumption statement.
        $order_dish_stmt->execute();
        $ingredient_consumption_stmt->execute();
    }
?>