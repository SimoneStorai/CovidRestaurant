<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Prepare users statement.
    $users_stmt = $db->prepare(
        "SELECT `id`, `mail`, `name` FROM `user`");

    // Execute query and parse its result.
    // Append to serialization array.
    $users = array();
    $users_stmt->execute();
    $result = $users_stmt->get_result();
    while ($row = $result->fetch_assoc())
       array_push($users, $row);

    // Echo as JSON array.
    header("Content-Type: application/json");
    echo(json_encode($users));
?>