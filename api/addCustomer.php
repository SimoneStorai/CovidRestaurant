<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("../config/db.php");

    // Decode authorization credentials.
    if (!assert_string_array($_POST, "mail", false))
    {
        echo("Invalid mail.");
        return;
    }
    $mail = $_POST["mail"];

    if (!assert_string_array($_POST, "password", false))
    {
        echo("Invalid password");
        return;
    }
    $password = $_POST["password"];

    // Prepare customer insert statement.
    $customer_stmt = $db->prepare("INSERT INTO `customer` (`table_id`, `date`) VALUES (?, ?)");
    $customer_stmt->bind_param("is", $table_id, $date);

    // Decode JSON customer data.
    $customer = json_decode($_POST["dish"]);

    // Parse table ID.
    if (!assert_int_array($customer, "table_id"))
    {
        echo("Invalid table ID.");
        return;
    }
    $table_id = $customer["table_id"];

    // Get current date in a SQL-compatible format.
    $date = date('Y-m-d H:i:s');

    // Execute custom insert statement.
    $customer_stmt->execute();
?>