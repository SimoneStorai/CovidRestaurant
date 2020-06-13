<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Prepare orders statement.
    $orders_stmt = $db->prepare(
        "SELECT o.`id`, o.`table_id`, o.`timestamp`, COALESCE(SUM(d.`price` * od.`quantity`), 0) AS `price` FROM `order` o
        LEFT JOIN `order_dish` od ON od.`order_id` = o.`id`
        LEFT JOIN `dish` d ON od.`dish_id` = d.`id`
        GROUP BY o.`id`");

    // Execute query and parse its result.
    // Append to serialization array.
    $orders = array();
    $orders_stmt->execute();
    $result = $orders_stmt->get_result();
    while ($row = $result->fetch_assoc())
       array_push($orders, $row);

    // Echo as JSON array.
    header("Content-Type: application/json");
    echo(json_encode($orders));
?>