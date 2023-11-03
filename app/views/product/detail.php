<h1>Chi tiết sản phẩm</h1>

@if (!empty($data['sub_content']['item']))
<h2>Mã sản phẩm: {{$data['sub_content']['item']->get_id()}}</h2>
<h2>Tên sản phẩm: {{$data['sub_content']['item']->get_name()}}</h2>
<h2>Giá: {{$data['sub_content']['item']->get_price()}}$</h2>
@else
<h2>Không tìm thấy sản phẩm</h2>
@endif