<?php
if (!function_exists("load_model")) {
    /**
     * Hàm sử dụng để load một model. Hàm này là alias của hàm LoadUtils::load_model
     */
    function model_loader($model_name): BaseModel
    {
        return LoadUtils::load_model($model_name);
    }
}
