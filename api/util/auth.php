<?php

    function auth()
    {
        include("integer.php");
        include("string.php");
        include("echo.php");
        include("../config/db.php");

        session_start();

        if (isset($_SESSION["id"]))
            return true;
    
        // Decode authorization credentials.
        if (!assert_string_array($_POST, "mail", false))
        {
            echo_error_json("Invalid mail provided.");
            return false;
        }
        $mail = $_POST["mail"];
    
        if (!assert_string_array($_POST, "password", false))
        {
            echo_error_json("Invalid password");
            return false;
        }
        $password = $_POST["password"];

        // Prepare login query.
        $login_stmt = $db->prepare("
            SELECT mail, password FROM user
            WHERE mail = ?");
        $login_stmt->bind_param("s", $mail);

        // Execute select query and fetch its data using PDO's utility.
        $login_stmt->execute();
        $result = $login_stmt->get_result();
        if ($row = $result->fetch_assoc())
        {
            $_mail = $row["mail"];
            $_password = password_hash($row["password"], PASSWORD_DEFAULT);

            if (password_verify($password, $_password))
            {
                // Init session.
                session_regenerate_id();
                $_SESSION["session_id"] = session_id();
                $_SESSION['session_user'] = $_mail;

                return true;
            }
        }

        return false;
    }
?>