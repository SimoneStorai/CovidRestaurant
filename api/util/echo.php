<?php
    function echo_error_json($error)
    {
        $output = array();
        $output["error"] = $error;
        header("Content-Type: application/json");
        echo(json_encode($output));
    }
?>