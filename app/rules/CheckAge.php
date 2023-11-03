<?php

namespace app\core\http_context;

class CheckAge implements IRules
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
