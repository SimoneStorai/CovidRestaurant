<?php
    include("../config/db.php");
    include("../util/integer.php");
    include("../util/double.php");
    include("../util/string.php");

    // Parse name.
    if (!assert_string_array($_POST, "name", false))
    {
        echo("Invalid dish name provided.");
        return;
    }
    $name = $_POST["name"];

    // Parse price.
    if (!assert_double_array($_POST, "price"))
    {
        echo("Invalid dish price provided.");
        return;
    }
    $price = doubleval($_POST["price"]);

    // Parse waiting time.
    if (!assert_string_array($_POST, "waiting_time", false))
    {
        echo("Invalid waiting_time provided.");
        return;
    }
    $waiting_time = $_POST["waiting_time"];

    // Parse category.
    if (!assert_string_array($_POST, "category", false))
    {
        echo("Invalid category provided.");
        return;
    }
    $category = $_POST["category"];

    // Parse description.
    if (!assert_string_array($_POST, "description", false))
    {
        echo("Invalid description provided.");
        return;
    }
    $description = $_POST["description"];

    // Parse image URL.
    if (assert_string_array($_POST, "image_url", false))
        $image_url = $_POST["image_url"];

    // Prepare dish insert statement.
    $dish_stmt = $db->prepare("INSERT INTO `dish` (`name`, `price`, `waiting_time`, `category`, `description`, `image_url`) VALUES (?, ?, ?, ?, ?, ?)");
    $dish_stmt->bind_param("sdssss", $name, $price, $waiting_time, $category, $description, $image_url);

    // Execute dish insert statement.
    $dish_stmt->execute();

    // Echo last inserted ID as JSON.
    echo("Dish added.");
?>