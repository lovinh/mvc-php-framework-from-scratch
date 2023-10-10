<?php
class Item extends BaseModel
{
    private $__id;
    private $__name;
    private $__price;
    function __construct($id, $name, $price)
    {
        $this->__id = $id;
        $this->__name = $name;
        $this->__price = $price;
    }
    public function __toString()
    {
        return "Item (id= " . $this->__id . ", name= " . $this->__name . ", price= " . $this->__price . ")";
    }
    public function get_id()
    {
        return $this->__id;
    }
    public function set_id($new_id)
    {
        $this->__id = $new_id;
    }

    public function get_name()
    {
        return $this->__name;
    }
    public function set_name($new_name)
    {
        $this->__name = $new_name;
    }

    public function get_price()
    {
        return $this->__price;
    }
    public function set_price($new_price)
    {
        $this->__price = $new_price;
    }
}
