@php 
use function app\core\helper\url;
@endphp
<H1>Đây là view test</H1>
<form action="{{url('delete')}}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="submit">
</form>