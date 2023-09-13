<?php
class BaseModel extends Database
{
    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }


}
