<?php
class LoadUtils
{
    /**
     * Load một model.
     * @param string $model_name Tên model cần load
     * @return BaseModel đối tượng model tương ứng nếu load thành công.
     */
    public static function load_model($model_name) : BaseModel
    {
        if (!file_exists(_DIR_ROOT . "/app/models/" . $model_name . '.php')) {
            // Handle error missing model file
            throw new ErrorException("File model '" . $model_name . ".php' not exist!");
        }
        require_once _DIR_ROOT . "/app/models/" . $model_name . '.php';
        if (!class_exists($model_name)) {
            // Handle error model class not exist
            throw new ErrorException("File model '" . $model_name . ".php' not exist!");
        }
        $model = new $model_name();
        return $model;
    }
}
