<?php
class Validator
{
    private $__field_name = "";
    private $__fields_data = [];
    private $__errors = [];
    private $__messages = [];
    private $__have_error = false;

    private function get_current_field_data()
    {
        if (!empty($this->__field_name)) {
            return $this->__fields_data[$this->__field_name];
        }
        return null;
    }
    /**
     * Thiết lập dữ liệu cho quá trình xác thực. Việc này là bắt buộc trước khi thực hiện việc xác thực.
     * @param array $field_data dữ liệu thu thập được cho quá trình xác thực.
     */
    public function set_fields_data($fields_data = [])
    {
        $this->__fields_data = $fields_data;
    }
    /**
     * Chỉ định tên trường được chọn để thực hiện xác thực
     * @param string $field_name Tên trường được chọn. 
     */
    public function field($field_name)
    {
        if (empty($this->__fields_data)) {
            throw new ValueError("VALIDATOR ERROR: Chưa thiết lập dữ liệu cho quá trình xác thực! Có lẽ bạn quên chỉ định validator->set_fields_data()");
        }
        if (!array_key_exists($field_name, $this->__fields_data)) {
            throw new ValueError("VALIDATOR ERROR: Trường '$field_name' không tồn tại trong mảng field_data! Kiểm tra lại các trường có trong request!");
        }
        if (!empty(trim($field_name))) {
            $this->__field_name = $field_name;
        }
        return $this;
    }
    /**
     * Thiết lập các thông báo cho từng loại xác thực cụ thể.
     * @param array $messages Mảng có dạng `["tên-trường.tên-xác-thực" => "thông-báo"]`.
     */
    public function set_message($messages = [])
    {
        $this->__messages = $messages;
        return $this;
    }
    /**
     * Lấy ra lỗi đầu tiên của một trường cụ thể. Nếu không chỉ định trường, một mảng lỗi gồm các lỗi đầu tiên của từng trường sẽ được trả về
     * @param string $field_name Tên trường được chỉ định
     * @return array Trả về một mảng chứa lỗi. Nếu không chỉ định trường, một mảng lỗi gồm các lỗi đầu tiên của từng trường sẽ được trả về. Nếu không có lỗi, mảng rỗng được trả về.
     */
    public function get_first_error($field_name = "")
    {
        if (empty($this->__errors)) {
            return [];
        }
        if (empty($field_name)) {
            $errors_array = [];
            foreach ($this->__errors as $key => $value) {
                $errors_array[$key] = reset($value);
            }
            return $errors_array;
        }
        if (!array_key_exists($field_name, $this->__errors)) {
            throw new ValueError("VALIDATOR ERROR: Trường '$field_name' không tồn tại trong mảng errors! Kiểm tra lại các trường có trong request!");
        }
        return reset($this->__errors[$field_name]);
    }
    /**
     * Lấy ra mảng chứa tập các lỗi của tất cả các trường hoặc một trường cụ thể
     * @param string $field_name Tên trường được chỉ định. Mặc định là rỗng. Nếu là rống, toàn bộ lỗi của quá trình xác thực được trả về.
     * @return array Trả về một mảng chứa lỗi. Nếu không có lỗi, mảng rỗng được trả về.
     */
    public function get_errors($field_name = "")
    {
        if (empty($field_name)) {
            return $this->__errors;
        }
        if (!empty($this->__errors)) {
            return $this->__errors[$field_name];
        }
    }
    private function set_error($field_name, $rule_name, $message)
    {
        if ((!empty($message)) || (!array_key_exists($this->__field_name . '.' . $rule_name, $this->__messages)) || empty($this->__messages[$this->__field_name . '.' . $rule_name])) {
            $this->__messages[$this->__field_name . '.' . $rule_name] = trim($message);
        }
        $this->__errors[$field_name][$rule_name] = $this->__messages[$field_name . '.' . $rule_name];
        $this->__have_error = true;
    }
    /**
     * Kiểm tra xem xác thực có xảy ra lỗi hay không
     * @return bool Trả về `true` nếu có lỗi xác thực. Ngược lại trả về `false`.
     */
    public function is_error()
    {
        return $this->__have_error;
    }

    // Validation function
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu không được để trống.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function required($message = "")
    {
        if (!empty($this->__fields_data[$this->__field_name])) {
            return $this;
        }

        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải có tối thiểu bao nhiêu ký tự
     * @param int $value Số ký tự tối thiểu cần có. Mặc định bằng 0.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function min_char($value = 0, $message = "")
    {
        if ((!is_int($value)) || $value < 0) {
            throw new RuntimeException("VALIDATOR ERROR: Giá trị phải là số nguyên không âm. Giá trị không phù hợp: '$value'");
        }
        if (strlen(trim($this->__fields_data[$this->__field_name])) >= $value) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn chỉ được có tối đa bao nhiêu ký tự
     * @param int $value Số ký tự tối đa được có
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function max_char($value, $message = "")
    {
        if ((!is_int($value)) || $value < 0) {
            throw new RuntimeException("VALIDATOR ERROR: Giá trị phải là số nguyên không âm. Giá trị không phù hợp: '$value'");
        }
        if ((!is_int($value)) || $value < 0) {
            throw new RuntimeException("VALIDATOR ERROR: Giá trị phải là số nguyên không âm. Giá trị không phù hợp: '$value'");
        }
        if (strlen(trim($this->__fields_data[$this->__field_name])) <= $value) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải có định dạng email
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function email($message = "")
    {
        if (filter_var($this->__fields_data[$this->__field_name], FILTER_VALIDATE_EMAIL)) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải trùng với trường dữ liệu có tên được chỉ định
     * @param string $field_name Trường dữ liệu được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function match($field_name, $message = "")
    {
        if (trim($this->__fields_data[$this->__field_name] == trim($this->__fields_data[$field_name]))) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn chỉ bảo gồm các ký tự trong bảng chữ cái tiếng Anh
     * @param string $field_name Trường dữ liệu được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function is_alpha($message = "")
    {
        if (ctype_alpha($this->get_current_field_data()))
            return $this;
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn chỉ bảo gồm các chữ số.
     * @param string $field_name Trường dữ liệu được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function numeric($message = "")
    {
        if (ctype_digit($this->get_current_field_data()))
            return $this;
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }


    /**
     * Phương thức tùy chỉnh luật xác thực
     */
    public function callback($rule_name, $func, $args = [], $message = "")
    {
        array_unshift($args, $this->get_current_field_data());
        if (call_user_func_array($func, $args)) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__ . '_' . $rule_name, $message);
        return $this;
    }
}
