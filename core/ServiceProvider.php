<?php
abstract class ServiceProvider
{
    protected Database $db;
    abstract public function boot();

    public function set_db(Database $db)
    {
        $this->db = $db;
    }
}
