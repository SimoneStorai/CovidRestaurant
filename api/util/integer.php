<?php
    function assert_int($var)
    {
        return  is_int(intval($var));
    }
    function assert_int_array($array, $index)
    {
        return  isset($array[$index])
                &&
                assert_int($array[$index]);
    }
?>