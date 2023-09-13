<?php
trait QueryBuilder
{
    private $_table;
    private $_where;
    private $_select_field;
    public function table($table_name)
    {
        $this->_table = $table_name;
        return $this;
    }
    public function where($field, $compare, $value)
    {
        if (!empty($this->_where)) {
            $this->_where .= " AND $field $compare '$value'";
        } else {
            $this->_where = " WHERE $field $compare '$value'";
        }
        return $this;
    }
    public function orwhere($field, $compare, $value)
    {
        if (!empty($this->_where)) {
            $this->_where .= " OR $field $compare '$value'";
        } else {
            $this->_where = " WHERE $field $compare '$value'";
        }
        return $this;
    }
    public function select_field($field = "*")
    {
        $this->_select_field = $field;
        return $this;
    }
    public function get()
    {
        $sql = "SELECT $this->_select_field FROM $this->_table $this->_where";
        $result = $this->query($sql);
        $this->reset();
        if (mysqli_num_rows($result) < 1) {
            return null;
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function first()
    {
        $sql = "SELECT $this->_select_field FROM $this->_table $this->_where";
        $result = $this->query($sql);
        $this->reset();
        if (mysqli_num_rows($result) < 1) {
            return null;
        }
        return $result->fetch(MYSQLI_ASSOC);
    }
    private function reset()
    {
        $_table = "";
        $_where = "";
        $_select_field = "";
    }
}
