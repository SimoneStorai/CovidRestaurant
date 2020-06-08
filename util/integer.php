<?php
    function assert_int($var)
    {
        return  isset($var)
                &&
                is_int($var);
    }
    function assert_int_array($array, $index)
    {
        return  isset($array[$index])
                &&
                assert_int($array[$index]);
    }
?>