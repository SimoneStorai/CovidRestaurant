<?php
    include("../util/integer.php");
    include("../util/string.php");
    include("config/db.php");

    if (isset($_SESSION["session_id"]))
    {
        echo("Already logged-in.");
    }

    // Parse mail.
    if (!assert_string_array($_POST, "mail", false))
    {
        echo("Invalid mail provided.");
        return;
    }
    $mail = $_POST["mail"];

    // Parse plain-text password.
    if (!assert_string_array($_POST, "password", false))
    {
        echo("Invalid password provided.");
        return;
    }
    $password = $_POST["password"];

    // Prepare login query.
    $login_stmt = $db->prepare("
        SELECT mail, password FROM user
        WHERE mail = ?");
    $login_stmt->bind_param("s", $mail);

    // Execute select query and fetch its data using PDO's utility.
    $login_stmt->execute()
    $user = $login_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || password_verify($password, $user["password"]))
    {
        // Bad login.
        echo("Invalid user credentials.");
    }
    else
    {
        // Init session.
        session_regenerate_id();
        $_SESSION["session_id"] = session_id();
        $_SESSION['session_user'] = $user["mail"];
    }
?>