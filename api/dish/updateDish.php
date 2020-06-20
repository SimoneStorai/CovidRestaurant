<?php
    include("../config/db.php");
    include("../util/integer.php");
    include("../util/double.php");
    include("../util/string.php");

    /*
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
    */

    // Get dish ID.
    if (!assert_int_array($_POST, "id"))
    {
        echo("Invalid dish ID provided.");
        return;
    }
    $id = $_POST["id"];

    // Parse new name.
    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid dish name provided.");
        return;
    }
    $name = $_POST["name"];

    // Parse new price.
    if (!assert_double_array($_POST, "price"))
    {
        echo("Invalid dish price provided.");
        return;
    }
    $price = doubleval($_POST["price"]);

    // Parse new waiting time.
    if (!assert_string_array($_POST, "waiting_time", false))
    {
        echo("Invalid waiting_time provided.");
        return;
    }
    $waiting_time = $_POST["waiting_time"];

    // Parse new category.
    if (!assert_string_array($_POST, "category", false))
    {
        echo("Invalid category provided.");
        return;
    }
    $category = $_POST["category"];

    // Parse new description.
    if (!assert_string_array($_POST, "description", false))
    {
        echo("Invalid description provided.");
        return;
    }
    $description = $_POST["description"];

    // Parse new image URL.
    if (!assert_string_array($_POST, "image_url", false))
    {
        echo("Invalid image URL provided.");
        return;
    }
    $image_url = $_POST["image_url"];

    // Prepare dish update statement.
    $dish_stmt = $db->prepare(
        "UPDATE dish SET 
        name = ?,
        price = ?,
        waiting_time = ?,
        category = ?,
        description = ?,
        image_url = ?
        WHERE id = ?");
    $dish_stmt->bind_param(
        "sdssssi", 
        $name, 
        $price, 
        $waiting_time,
        $category,
        $description, 
        $image_url, 
        $id);

    // Execute dish update statement.
    $dish_stmt->execute();
?>