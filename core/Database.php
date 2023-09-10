<?php
class Database
{
    private $__conn;
    function __construct()
    {
        $this->__conn = Connection::getInstance();
    }

    public function query($sql)
    {
        $result = mysqli_query($this->__conn->get_connection(), $sql);
        if (!empty($this->__conn->get_connection()->connect_error)) {
            throw new RuntimeException("DATABASE CONNECTION FAIL: " . $this->__conn->get_connection()->connect_error . "! ('sql='" . $sql . "')");
        }
        if (!empty($this->__conn->get_connection()->error)) {
            throw new RuntimeException("DATABASE QUERY FAIL: " . $this->__conn->get_connection()->error . "! ('sql='" . $sql . "')");
        }
        return $result;
    }
}
