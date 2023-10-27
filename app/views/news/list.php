<h1>DANH SÁCH TIN TỨC</h1>

<div>{{ $data["new_title"]  }}</div>
<div>{{ $data["new_content"]    }}</div>
<div>{{ to_slug("Một cái gì đó") }}</div>
@if ( !empty($data["new_author"]) )
<div>Tên tác giả: {{$data["new_author"]}}</div>
@else
<div>Không có gì</div>
@endif

@if (md5('abc') == '')
<h4>Something</h4>
@elif('1==1')
<h4>{{md5("ac")}}</h4>
@endif

@php
$number = 1;
$list = [
'Tin 1',
'Tin 2',
'Tin 3',
'Tin 4',
'Tin 5'
];
@endphp

{{$number}}

<div>
    ACBCADaw
    @for ($i = 1; $i < count($list); $i++)
    <h4>{{$list[$i]}}</h4>
    @endfor
</div>