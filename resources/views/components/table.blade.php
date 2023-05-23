
    <table class="table table-striped table-bordered table-hover table-sm " id="{{$id??'table'}}">
        <thead class="thead-dark">
            <tr>
                @foreach ($headers as $key => $header )
                    @if (is_numeric($key))
                        <th class="{{$header}} {{$class??''}}">{{ ucwords(str_replace('_',' ',explode(".",explode(" ",$header)[0])[array_key_last(explode(".",explode(" ",$header)[0]))]))}}</th>
                    @elseif ($header=='')
                        <th class="{{$key}} {{$class??''}}">{{ ucwords(str_replace('_',' ',explode(".",explode(" ",$key)[0])[array_key_last(explode(".",explode(" ",$key)[0]))]))}}</th>
                    @else
                        <th class="{{$key}} {{$class??''}}">{{ ucwords(str_replace('_',' ',$header))}}</th>
                    @endif
                @endforeach
                @empty($no_action)
                <th class="action">Action</th>
                @endempty

            </tr>
        </thead>
            <?= $body??'' ?>
    </table>


