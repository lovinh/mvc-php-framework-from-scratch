<?php
class View
{
    public static $data_share = [];
    public static function share($data)
    {
        self::$data_share = $data;
    }
}