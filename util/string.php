<?php
    function assert_string($var, $can_be_empty)
    {
        return  isset($var)
                &&
                is_string($var)
                &&
                ($can_be_empty || strlen($var) > 0); 
    }
?>