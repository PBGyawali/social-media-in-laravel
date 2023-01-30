<div class="row " id="chatmessage_<?=$chat->id?>">
    <div class="col">
        <div class="card alert <?= $background_class?> rounded-0" >
            <div class=" d-flex  <?=$row_class?>   justify-content-between align-items-center float-right border-0" >
            <div class="dropdown-list-image mr-3 ">
                <img class="rounded-circle" src="<?=$chat->sender->profile_image?>" height="35" width="35">
            </div>
                    <a class="d-flex <?=$row_class?> align-items-center w-100 text-left whitespace-normal ">
                        <div class="text-left ">
                            <div class="">
                                <span>
                                    <p class="text-dark">
                                        <?=$chat->message?>
                                    </p>
                                </span>
                            </div>
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
                <div class="dropdown no-arrow">
                    <button class="btn btn-link btn-sm" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v text-blue-400"></i></button>
                    <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                        <a class="dropdown-item pt-0 delete" data-id="<?=$chat->id?>">Delete this message</a>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
