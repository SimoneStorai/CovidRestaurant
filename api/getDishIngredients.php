<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("config/db.php");

    // Parse dish ID.
    if (!assert_int_array($_GET, "id"))
    {
        echo("Invalid dish ID provided.");
        return;
    }
    $id = intval($_GET["id"]);

    // Prepare dish ingredients select statement.
    $dish_stmt = $db->prepare(
        "SELECT i.id AS id, i.name AS name, i.quantity AS stock_quantity, di.quantity AS required_quantity
        FROM ingredient i JOIN dish_ingredient di ON di.ingredient_id = i.id WHERE di.dish_id = ?");
    $dish_stmt->bind_param("i", $id);

    // Execute query and parse its result.
    $ingredients = array();
    $dish_stmt->execute();
    $result = $dish_stmt->get_result();
    while ($row = $result->fetch_assoc())
        array_push($ingredients, $row);

    // Echo ingredients as JSON aray.
    header("Content-Type: application/json");
    echo(json_encode($ingredients));
?>