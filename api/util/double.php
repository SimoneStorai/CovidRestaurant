<?php
    function assert_double($var)
    {
        return  is_double(doubleval($var));
    }
    function assert_double_array($array, $index)
    {
        return  isset($array[$index])
                &&
                assert_double($array[$index]);
    }
?>