<?php
    function assert_string($var, $can_be_empty)
    {
        return  is_string($var)
                &&
                ($can_be_empty || strlen($var) > 0); 
    }
    function assert_string_array($array, $index, $can_be_empty)
    {
        return  isset($array[$index])
                &&
                assert_string($array[$index], $can_be_empty);
    }
?>