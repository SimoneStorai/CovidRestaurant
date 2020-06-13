<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Prepare ingredients select statement.
    $ingredients_stmt = $db->prepare("SELECT * FROM `ingredient`");

    // Execute query and parse its result.
    // Append to serialization array.
    $ingredients = array();
    $ingredients_stmt->execute();
    $result = $ingredients_stmt->get_result();
    while ($row = $result->fetch_assoc())
       array_push($ingredients, $row);

    // Echo as JSON array.
    header("Content-Type: application/json");
    echo(json_encode($ingredients));
?>