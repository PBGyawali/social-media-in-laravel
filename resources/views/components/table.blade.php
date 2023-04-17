<div class="table-responsive ">
    <table class="table table-striped table-bordered " id="table">
        <thead>
            <tr>
                @foreach ($headers as $key => $header )
                    @if (is_numeric($key))
                        <th class="{{$header}} {{$class??''}}">{{ucwords(str_replace("_", " ", $header))}}</th>
                    @elseif ($header=='')
                        <th class="{{$key}} {{$class??''}}">{{ucwords(str_replace("_", " ", $key))}}</th>
                    @else
                        <th class="{{$key}} {{$class??''}}">{{ucwords($header)}}</th>
                    @endif
                @endforeach
                <th class="action">Action</th>
            </tr>
        </thead>
            <?= $body??'' ?>
    </table>
</div>


