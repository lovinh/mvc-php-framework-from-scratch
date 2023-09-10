<?php
class Connection
{
    private static $instance = null;

    private $__conn;

    private function __construct()
    {
        // Connect to the database;
        global $database_config;
        mysqli_report(MYSQLI_REPORT_STRICT);
        $this->__conn = mysqli_connect($database_config["server"], $database_config["user"], $database_config["password"], $database_config["db_name"]);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }

    public function get_connection()
    {
        return $this->__conn;
    }
}
