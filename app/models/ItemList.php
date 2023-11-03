<?php

namespace app\core\model;

use function app\core\helper\load_model;
use function app\core\helper\model_path;

// use app\core\model\Item;

class ItemList extends BaseModel
{
    private $items;
    function __construct()
    {
        load_model("Item");
        $this->items = array(
            new Item(0, "Item 0", 50),
            new Item(1, "Item 1", 100),
            new Item(2, "Item 2", 200),
            new Item(3, "Item 3", 250),
            new Item(4, "Item 4", 250),
            new Item(5, "Item 5", 350),
            new Item(6, "Item 6", 520),
            new Item(7, "Item 7", 140),
            new Item(8, "Item 8", 70),
            new Item(9, "Item 9", 830),
            new Item(10, "Item 10", 220),
        );
    }


    public function get_list_items()
    {
        return $this->items;
    }

    public function get_item_by_id($id)
    {
        foreach ($this->items as $value) {
            if ($value->get_id() == $id)
                return $value;
        }

        return null;
    }
}
