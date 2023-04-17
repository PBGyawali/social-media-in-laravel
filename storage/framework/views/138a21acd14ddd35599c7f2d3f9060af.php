                    <div class="row " id="message_header_<?= $chat->id; ?>">
                        <div class="col-lg-12 col-xl-12 col-sm-12">
                            <div class="card shadow mb-3 alert-notification " >
                                <div class=" d-flex justify-content-between align-items-center float-right" >
                                    <div class="dropdown-list-image mr-3 ">
                                        <img class="rounded-circle" src="<?= $chat->profile_image; ?>" height="60" width="60">
                                        <div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-5 text-left position-absolute" role="status" style="z-index:5;margin-left:-17px;">
                                            <i class="fa fa-circle text-success" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <a class="d-flex align-items-center dropdown-item mt-3" href="<?= route('conversation',$chat->sender_id); ?>" style="white-space: normal;cursor:pointer;">
                                        <div class="text-left ">
                                            <div class="">
                                                <span> <p class=""><?= $chat->message;?></p></span>
                                            </div>
                                            <span class="">
                                                <span class="small mb-0  font-weight-bold"><?= ($user_id==$chat->sender_id)?'You':$chat->username;?></span>
                                                <p class="small mb-0 d-inline">-<?= $chat->sent_on; ?></p>
                                            </span>
                                        </div>
                                    </a>
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-link btn-sm" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v text-blue-400"></i></button>
                                        <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $chat['sender_id']; ?>" data-id="<?= $chat['id']; ?>" style="cursor:pointer" data-method_type="/delete" data-action="delete"       >Delete this conversation</a>
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $chat['sender_id']; ?>" data-id="<?= $chat['id']; ?>" style="cursor:pointer" data-method_type="/update" data-action="notification" >Turn off notification</a>
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $chat['sender_id']; ?>" data-id="<?= $chat['id']; ?>" style="cursor:pointer" data-method_type="/update" data-action="read"         >Mark as Read</a>
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $chat['sender_id']; ?>" data-id="<?= $chat['id']; ?>" style="cursor:pointer" data-method_type="/update" data-action="archive"      >Archive</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/message_body.blade.php ENDPATH**/ ?>