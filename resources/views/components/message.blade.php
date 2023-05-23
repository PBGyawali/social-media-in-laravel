<span class="text-center position-absolute w-100"id="message" style="z-index:50">
    <?php
        $usermessages = array('message','error'); ?>
        @foreach($usermessages as $key)
            @if(session()->has($key))
                    <div class="alert alert-danger alert-dismissible fade show" id="alert">
                        {!! session($key) !!}
                        <button type="button" class="close" onclick="hide()">&times;</button>
                    </div>
             @endif
        @endforeach
        @if ($errors->any())
            <div>
                <div class="alert alert-danger" role="alert" id="alert">
                        <button type="button" class="close" onclick="hide()">&times;</button>
                        @foreach ($errors->all() as $error)
                            <div>Error {{$loop->iteration}}. {{ $error }}</div>
                        @endforeach
                </div>
            </div>
        @endif
</span>

