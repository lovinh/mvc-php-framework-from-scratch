<?php
class Database
{
    private $__conn;

    use QueryBuilder;

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

    public function select(string $table, $field = "*", $optional = [])
    {
        $condition = "";
        $distinct = "";
        $order_by = "";
        $limit = "";
        $offset = "";
        $desc = "";
        if (isset($optional['distinct'])) {
            $distinct = "DISTINCT";
        }
        if (isset($optional["condition"])) {
            $condition = "WHERE " . $optional["condition"];
        }
        if (isset($optional["order_by"])) {
            $order_by = "ORDER BY " . implode(",", $optional["order_by"]);
        }
        if (isset($optional["limit"])) {
            $limit = "LIMIT " . $optional["limit"];
            if (isset($optional["offset"])) {
                $offset = "OFFSET " . $optional["offset"];
            }
        }
        if (isset($optional["desc"])) {
            $desc = "DESC" . $optional["desc"];
        }
        $sql = "SELECT " . $distinct . " " . $field . " FROM " . $table . " " . $condition . " " . $order_by . " " . $desc . " " . $limit . " " . $offset . ";";

        $result = $this->query($sql);

        if (mysqli_num_rows($result) < 1) {
            return null;
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert($table, $fields_values = [])
    {
        $fields = implode(",", array_keys($fields_values));
        $values = implode("','", array_values($fields_values));
        $sql = "INSERT INTO $table($fields) VALUES ('$values')";
        return $this->query($sql);
    }

    public function update($table, $fields_values = [], $condition = "1")
    {
        $setting = "";
        foreach ($fields_values as $key => $value) {
            $setting .= "$key = '" . $value . "',";
        }
        $setting = rtrim($setting, ',');
        $sql = "UPDATE $table SET $setting WHERE $condition;";
        return $this->query($sql);
    }

    public function delete($table, $condition = "0")
    {
        $sql = "DELETE FROM $table WHERE " . $condition;
        return $this->query($sql);
    }
}
