<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("config/db.php");

    // Prepare dishes select statement.
    $dishes_stmt = $db->prepare(
        "SELECT d.id AS id, d.name AS name, d.price AS price, d.waiting_time AS waiting_time, d.image_url AS image_url, 
        MIN(FLOOR(i.quantity / di.quantity)) AS units FROM dish_ingredient di
        JOIN dish d ON di.dish_id = d.id
        JOIN ingredient i ON di.ingredient_id = i.id 
        HAVING units > 0;"
    );

    // Execute query and parse its result.
    // Append to serialization array.
    $dishes = array();
    $dishes_stmt->execute();
    $result = $dishes_stmt->get_result();
    while ($row = $result->fetch_assoc())
       array_push($dishes, $row);

    // Echo as JSON array.
    header("Content-Type: application/json");
    echo(json_encode($dishes));
?>