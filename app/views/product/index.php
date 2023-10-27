<h1>Trang sản phẩm</h1>
<h2>Author: {{$data["author"]}}</h2>

@foreach ($data['sub_content']['list_items'] as $value)
<div>
    <h2>id: {{$value->get_id()}}</h2>
    <h2>Name: {{$value->get_name()}}</h2>
    <h2>Price: {{$value->get_price()}} $</h2>
</div></br>
@endforeach