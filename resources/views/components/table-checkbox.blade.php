@foreach($columns as $key=> $column)
<input type="checkbox"
        class=toggle
        data-column="{{$key}}">  {{ucwords(str_replace("_", " ", $column))}}
@endforeach



