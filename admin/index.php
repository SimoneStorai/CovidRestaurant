<?php
    session_start();

    if (isset($_SESSION["id"]))     header("Location: menu.html");
    else                            header("Location: login/");
?>