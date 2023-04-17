<span class="text-center position-absolute w-100"id="message" style="z-index:50" onclick="hide()">
    <?php
        $usermessages = array('message','error'); ?>
        @foreach($usermessages as $key)
            @if(session()->has($key))
                    {!! session($key) !!}
             @endif
        @endforeach
</span>
