<div class="row removable_div_<?=$chat->id?> mt-1 " id="chatmessage_<?=$chat->id?>">
    <div class="col">
        <div class="card border-0 px-1 py-0 rounded-pill <?= $background_class?>" >
            <div class=" d-flex  <?=$row_class?>   justify-content-start align-items-center float-right border-0" >
               
                    <img class="rounded-circle myDIV mr-3" src="<?=$chat->sender->profile_image?>" height="35" width="35">
                
                <a class="d-flex <?=$row_class?> align-items-center trigger-hover w-100 text-left whitespace-normal ">
                    <div class="text-left ">  
                        <p class="text-dark py-0 my-0"> 
                            <?=$chat->message?>                                
                        </p>
                        <span class="<?=$float?>">
                            <span class="small mb-0  font-weight-bold">
                                <?= ($id==$chat->sender_id?'You':$chat->sender->username)?>
                            </span>
                            <p class="small mb-0 d-inline text-gray-500">
                                -<?=$chat->sent_on?>
                            </p>
                        </span>
                   </div>
                </a>
                <div class="dropdown no-arrow content-hover">
                    <button class="btn btn-link btn-sm" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                    <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in py-0" role="menu">
                        <button class="dropdown-item delete" data-sender_id="{{$chat->sender_id}}" data-action="delete" data-id="<?=$chat->id?>">Delete this message</button>
                        @if(auth()->user()->is_same_user($chat->sender_id))
                        <button class="dropdown-item delete" data-sender_id="{{$chat->sender_id}}" data-action="delete_for_all" data-id="<?=$chat->id?>">Delete for all</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
