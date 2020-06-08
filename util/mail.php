<?php
    // Mail assertion function.
    // Returns if its valid or not.
    function assert_mail($mail)
    {
        return filter_var(
            sanitize_mail($mail), 
            FILTER_VALIDATE_EMAIL);
    }

    // Mail sanitization function.
    function sanitize_mail($mail)
    {
        return filter_var($mail, FILTER_SANITIZE_EMAIL);
    }
?>