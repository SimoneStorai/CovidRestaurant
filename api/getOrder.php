<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("config/db.php");

    // Parse order ID.
    if (!assert_int_array($_GET, "id"))
    {
        echo("Invalid order ID provided.");
        return;
    }
    $id = intval($_GET["id"]);

    // Prepare order select statement.
    $order_stmt = $db->prepare(
        "SELECT d.id, d.name, d.price, d.waiting_time, d.description, d.category, od.quantity
        FROM order_dish od JOIN dish d ON d.id = od.dish_id WHERE od.order_id = ?");
    $order_stmt->bind_param("i", $id);

    // Execute query and parse its result.
    // Append to serialization array.
    $orders = array();
    $order_stmt->execute();
    $result = $order_stmt->get_result();
    while ($row = $result->fetch_assoc())
       array_push($orders, $row);

    // Echo as JSON array.
    header("Content-Type: application/json");
    echo(json_encode($orders));
?>