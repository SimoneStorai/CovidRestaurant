<?php
    include("../util/auth.php");

    // Authenticate user.
    if (!auth())
        echo("Invalid credentials.");
?>