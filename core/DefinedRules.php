<?php

use function PHPSTORM_META\type;

trait DefinedRules
{
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
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn là ngày ngay sau ngày được chỉ định.
     * @param string $date Ngày được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function after($date, $message = '')
    {

        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn là ngày ngay sau hoặc bằng ngày được chỉ định.
     * @param string $date Ngày được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function after_or_equal($date, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn chỉ bao gồm các ký tự `[a-z][A-Z]` hoặc chữ số `[0-9]`.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function alpha_num($message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải là một mảng.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function array($message = '')
    {
        if (!is_array($this->get_current_field_data())) {
            $this->set_error($this->__field_name, __FUNCTION__, $message);
        }
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn là ngày ngay trước ngày được chỉ định.
     * @param string $date Ngày được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function before($date, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn là ngày ngay trước hoặc bằng ngày được chỉ định.
     * @param string $date Ngày được chỉ định
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function before_or_equal($date, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn có giá trị nằm trong khoảng `($min, $max)`
     * @param int|float $min Giá trị nguyên hoặc thực nhỏ nhất của khoảng.
     * @param int|float $max Giá trị nguyên hoặc thực lớn nhất của khoảng.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function between($min, $max, $message = '')
    {
        if (!(is_int($min) || is_float($min))) {
            throw new InvalidArgumentException("VALIDATOR VALUE WRONG TYPE: Giá trị chỉ định value phải là số nguyên hoặc số thực. Phát hiện kiểu không hợp lệ '" . gettype($min) . "'.");
        }
        if (!(is_int($max) || is_float($max))) {
            throw new InvalidArgumentException("VALIDATOR VALUE WRONG TYPE: Giá trị chỉ định value phải là số nguyên hoặc số thực. Phát hiện kiểu không hợp lệ '" . gettype($max) . "'.");
        }

        if (filter_var($this->get_current_field_data(), FILTER_VALIDATE_INT) !== FALSE && filter_var($this->get_current_field_data(), FILTER_VALIDATE_FLOAT) !== FALSE && $this->get_current_field_data() > $min && $this->get_current_field_data() < $max) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải là ngày tháng.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function date($message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải là ngày tháng bằng với ngày tháng được chỉ định
     * @param string $date Ngày được chỉ định.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function date_equal($date, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải là ngày tháng có định dạng được chỉ định
     * @param string $format Định dạng của ngày được chỉ định.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function date_format($format, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải là dạng số học có số lượng số sau dấu thập phân từ `$min` đến `$max`. Để quy định chính xác bao nhiêu số sau dấu thập phần, chỉ định `$min` = `$max`.
     * @param int $min số lượng số nhỏ nhất.
     * @param int $min số lượng số lớn nhất.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function decimal($min, $max, $message = '')
    {
        return $this;
    }

    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn phải khác với trường được chỉ định.
     * @param string $field tên trường được chỉ định.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function different($field_name, $message = '')
    {
        if ($this->get_current_field_data() == $this->get_field_data($field_name)) {
            $this->set_error($this->__field_name, __FUNCTION__, $message);
        }
        return $this;
    }

    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn bị loại bỏ khi trả về dữ liệu xác thực.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function exclude($message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn bị loại bỏ khi trả về dữ liệu xác thực nếu một trường khác có kết quả bằng với kết quả chỉ định.
     * @param string $field tên trường được chỉ định.
     * @param object $value giá trị được chỉ định.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function exclude_if($field, $value, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn có giá trị nguyên.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function integer($message = '')
    {
        $val = filter_var($this->get_current_field_data(), FILTER_VALIDATE_INT);
        if ($val !== FALSE) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn có giá trị thực.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function float($message = '')
    {
        $val = filter_var($this->get_current_field_data(), FILTER_VALIDATE_FLOAT);
        if ($val !== FALSE) {
            return $this;
        }
        $this->set_error($this->__field_name, __FUNCTION__, $message);
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn có giá trị có định dạng trùng với mẫu $pattern. Mẫu $pattern là một biểu thức chính quy.
     * @param string $pattern biểu thức chính quy nhằm xác định định dạng của trường được chọn.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function like($pattern, $message = '')
    {
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn có giá trị không được nhỏ hơn giá trị chỉ định.
     * @param int|float $value Giá trị thực hoặc nguyên là giá trị nhỏ nhất mà trường được chọn có thể bằng.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function min($value, $message = '')
    {
        if (!(is_int($value) || is_float($value))) {
            throw new InvalidArgumentException("VALIDATOR VALUE WRONG TYPE: Giá trị chỉ định value phải là số nguyên hoặc số thực. Phát hiện kiểu không hợp lệ '" . gettype($value) . "'.");
        }
        if ($this->get_current_field_data() < $value) {
            $this->set_error($this->__field_name, __FUNCTION__, $message);
        }
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn có giá trị không được lớn hơn giá trị chỉ định.
     * @param int|float $value Giá trị thực hoặc nguyên là giá trị lớn nhất mà trường được chọn có thể bằng.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function max($value, $message = '')
    {
        if (!(is_int($value) || is_float($value))) {
            throw new InvalidArgumentException("VALIDATOR VALUE WRONG TYPE: Giá trị chỉ định value phải là số nguyên hoặc số thực. Phát hiện kiểu không hợp lệ '" . gettype($value) . "'.");
        }
        if ($this->get_current_field_data() > $value) {
            $this->set_error($this->__field_name, __FUNCTION__, $message);
        }
        return $this;
    }
    /**
     * Phương thức xác thực yêu cầu trường dữ liệu được chọn chỉ bao gồm các ký tự unicode.
     * @param string $message Thông báo nếu vi phạm trường xác thực này. Mặc định để trống. Nếu đã cài đặt thông báo tại phương thức `set_message()` thì thông báo đó sẽ bị ghi đè bởi thông báo mới.
     */
    public function unicode($message = '')
    {
        return $this;
    }
}
