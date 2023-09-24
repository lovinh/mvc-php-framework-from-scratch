# Validate

## Công việc cần thực hiện

1. Cài đặt các luật (Set rules)

- fieldname
- rules

2. Đưa ra thông báo

- filename
- error

3. Run validate

- true
- false

## Triển khai theo class:

**Ví dụ về một cấu trúc validate**:

`request->validate->field("name")->required()->min(5)->max(30)`

**Lấy lỗi**: `request->validate->errors`

**Trả về**:

```php
Array(
    [name] => Array(
            [required] => "Tên không được để trống",
            ...
        ),
    [email] => Array(
        ...
    )
)
```

Mỗi function như `required()` hay `min()` đều có một cài đặt check lỗi riêng.

Như vậy class validate bao gồm

**Thuộc tính**

- `field_name`: Tên trường cần sử dụng để validate
- `error`: Chứa lỗi
- `message`: chứa message
- `have_error`: kiểm tra xem có xảy ra lỗi xác thực hay không

**Phương thức**

- `field(<tên-field>)`: Chỉ định trường cần set validate
- `<tên-validator>(<tham-số>, <message>)`: Hàm validate
- `set_message(message = [])`: Hàm set message. Tham số truyền vào dạng `"tên-validation" => "message"`
- `get_error(<tên-field>)`: Trả về lỗi của trường cụ thể
- `is_error()`: Trả về true nếu xảy ra lỗi, ngược lại trả về true

## Một số luật validate có thể tự xây dựng:

Các luật sau được lựa chọn theo bộ luật dựa theo framework lavarel. Tham khảo: https://laravel.com/docs/10.x/validation#available-validation-rules.

_Các luật validation tổng quát:_

- **after($date)**: Trường được chọn là ngày sau ngày chỉ định
- **after_or_equal($date)**: Trường được chọn là ngày sau hoặc là chính ngày được chỉ định.
- **alpha**: Trường được chọn chỉ bao gồm các ký tự [a-z][A-Z]
- **alpha_num**: Trường được chọn chỉ bao gồm các ký tự [a-z][A-Z] hoặc chữ số [0-9]
- **array**: Trường được chọn có dạng mảng.
- **before($date)**: Trường được chọn là ngày phía trước ngày được chỉ định.
- **before_or_equal($date)**: Trường được chọn là ngày phía trước hoặc là chính ngày được chỉ định.
- **between($min, $max)**: Trường được chọn có giá trị nằm trong khoảng ($min, $max)
- **date**: Trường được chọn là ngày tháng.
- **date_equal($date)**: Trường được chọn là ngày trùng với ngày $date
- **date_format($date)**: Trường được chọn có ngày có dạng giống với dạng của $date
- **decimal($min, $max)**: Trường được chọn là dạng số học có số lượng số sau dấu thập phân từ $min đến $max. Để quy định chính xác bao nhiêu số sau dấu thập phần, chỉ định $min = $max.
- **different($field)**: Trường được chọn phải khác với trường $field
- **email**: Trường được chọn phải có định dạng email.
- **like($pattern)**: Trường được chọn có giá trị có định dạng trùng với mẫu $pattern. Mẫu $pattern là một biểu thức chính quy.
- **min($value)**: Trường được chọn có giá trị không được nhỏ hơn giá trị chỉ định.
- **max($value)**: Trường được chọn có giá trị không được lớn hơn giá trị chỉ định.
- **min_char($value)**: Trường được chọn có số lượng ký tự không ít hơn $value ký tự.
- **max_char($value)**: Trường được chọn có số lượng ký tự không nhiều hơn $value ký tự.
- **match($field)**: Trường được chọn phải trùng với trường $field
- **required**: Trường được chọn phải có dữ liệu.
- **unicode**: Trường được chọn chỉ bao gồm các ký tự unicode.

_Các luật validation với DB:_

- **unique($table, $field)**: Trường được chọn phải duy nhất trong bảng và trường được chỉ định. Nếu cột $field không được chỉ định thì tên trường được xét duy nhất sẽ chính là tên trường được chọn. Ví dụ: `field('email')->unique('users')` sẽ xác thực email phải duy nhất trên trường _email_ trong bảng _user_.
- **ignore($field, $value)**: Chỉ đi kèm với `unique()`. Bỏ qua validate với trường có giá trị bằng value. Ví dụ: Trong một trang sửa thông tin người dùng, người dùng có thể chỉnh sửa email của mình. Ta muốn email được sửa phải có giá trị duy nhất. Tuy nhiên, nếu người dùng không sửa email mà chỉ sửa tên, thì email cũ của người dùng đã tồn tại trong CSDL và sẽ bị trình xác thực báo lỗi. Do đó, cần chỉ thêm một trường hợp nếu email này thuộc về user có user_id = 20 (bản thân người dùng), để bỏ qua email hiện tại của người dùng và chỉ xét các email khác.
- **where(QueryBuilder $query)**: Chỉ đi kèm với `unique()`. Chỉ định việc xác thực `unique()` được thực hiện trên phạm vi của truy vấn nào. Ví dụ dưới đây trình xác thực sẽ chỉ xác thực trường email duy nhất trên trường email bảng users chỉ trong phạm vi của bản ghi có user_id > 1 (Giả sử user_id = 1 là admin)

```php
    field('email')->unique('users')->where(fn (QueryBuilder $query) => $query->where("user", ">", 1))
```

_Luật Validation tùy chỉnh_: Sử dụng trong trường hợp muốn tự xây dựng một luật xác thực cho các trường hợp cụ thể mà không có luật có sẵn nào có thể sử dụng.
- **callback($rule_name, $func, $message**