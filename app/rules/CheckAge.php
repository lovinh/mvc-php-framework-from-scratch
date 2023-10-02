<?php
class CheckAge implements Rules
{
    public function __construct()
    {
        echo "CheckAge";
    }
    public function validate($args = [])
    {
        extract($args);
        return $field >= $min_age;
    }
}
