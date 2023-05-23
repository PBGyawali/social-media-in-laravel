<li class="dropdown mx-1" role="presentation">
    <div class=" dropdown ">
        <a class="dropdown position-relative mr-2 cursor-pointer " data-toggle="dropdown" aria-expanded="false" >
                <i class="fas fa-envelope fa-fw"></i>
            <span class="badge badge-danger badge-counter position-absolute py-0 pr-0 ml-0 mr-2" style="top:0;left:2;" id="messagecount">
                @isset($messagecount)
                    @if($messagecount>0)
                        {{$messagecount}}
                        @if($messagecount>=3)
                        +
                        @endif
                    @endif
                @endisset
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right border-0 pb-0"	role="menu">
            <h6 class="dropdown-header alert-primary text-center px-0">Your Messages</h6>
           @if(isset($messages) &&!$messages->isEmpty())
                @foreach ($messages as $key => $message)
                    <div class="dropdown">
                        <div class="dropdown-list  ">
                            <a class="d-flex align-items-center dropdown-item cursor-pointer whitespace-normal">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle " src="<?= $message->profile_image; ?>"height="60" width="60">
                                    <div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-5 text-left position-absolute z-10" role="status" style="margin-left:-17px;">
                                        <i class="fa fa-circle text-success" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="d-inline-block text-truncate" style="max-width: 350px;"><span><?=( auth()->user()->is_same_user($message->sender_id)?'You: ':$message->username.':').$message->message; ?></span></div>
                                    <p class="small text-gray-600 mb-0"><?= $message->username; ?> - <?= $message->sent_on; ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                <a class="text-center dropdown-item small text-gray-500" href="<?=route($side.'messages')?>">Show All Messages </a>
            @else
                @include('no_messages')
            @endif
        </div>
    </div>
</li>



