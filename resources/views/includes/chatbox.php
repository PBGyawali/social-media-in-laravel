 <?php
$username=auth()->user()->username;
$profileimage=auth()->user()->profile_image;
?>
<div class="container d-none d-sm-block">
    <div class="row">
        <div class=" col xs-0 col sm-0 col-md-12">
            <button class="open-button cursor-pointer bg-white position-fixed
                rounded-circle z-50 text-7xl opacity-80 hover:opacity-100 hover:text-white focus:outline-none no-shadow bottom-6 right-6">
                <i class="chatboxicon text-dark fa fa-comments fa-1x"></i>
            </button>
            <div class="chat-popup position-fixed border-0 d-none z-50 mb-5 right-0 bottom-7" id="chatbox">
                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active tabbutton" data-id="ex1-tabs-0" data-mdb-toggle="tab" href="#ex1-tabs-0" role="tab" aria-controls="ex1-tabs-0" aria-selected="true">Message</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link tabbutton" data-id="ex1-tabs-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="false">Support</a>
                    </li>
                </ul>

                <!-- Tabs content -->
                <div class="tab-content  w-80 max-w-sm bottom-7" id="ex1-content">
                    <div class="tab-pane show active" id="ex1-tabs-0" role="tabpanel" aria-labelledby="ex1-tab-0">
                        <div class="card shadow mb-4">
                            <div class="card-header p-0">
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body h-60 p-0 overflow-y-auto " id="user_list">
                                                <div class="list-group list-group-flush">
                                                    <?php if(isset($userdata) && !$userdata->isEmpty() ):?>
                                                        <?php foreach($userdata as $key => $user):?>
                                                            <?php if($user->id != auth()->id()):?>
                                                        <a class="list-group-item-action">
                                                                <img src="<?= $user->profile_image?>"
                                                                class="img-fluid rounded-circle img-thumbnail" width="50" />
                                                                <span class="ml-1"><strong><?=$user->username ?></strong></span>
                                                                <span class=" ml-1 mt-2 float-right"><?= '<i class="fa fa-circle text-'.
                                                                ($user->userlog->last_logout <= today()?'success':'danger').'"></i>';?></span></a>
                                                            <?php endif	?>
                                                        <?php endforeach?>
                                                    <?php endif	?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end of 1st tab div content -->
                    <div class="tab-pane show " id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                        <div class="card shadow ">
                            <div class="card-header bg-none">
                                <div class="row">
                                    <div class="col h-40 ">
                                            <div ><i class="fas fa-comment chatboxicon p-0"></i> Support: </div>
                                            <span class="usermessage">Hello <?= $username?>. What can we do for you?</span>
                                            <p><span class="usermessagedate" id="usermessagedate"></span></p>
                                            <span id="typing_on"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="post" id="chat"class="form-container p-0 text-base bg-none opacity-80 w-80 max-w-sm" data-parsley-errors-container="#validation_error">
                            <div class="input-group mb-3">
                                    <textarea  id="sender_msg" name="message" placeholder="Type Message Here"
                                    class="msg form-control bg-secondary text-white focus:outline-black" autocomplete="off"
                                    data-parsley-trigger="keyup" required></textarea>
                                    <div class="input-group-append">
                                        <button type="submit" name="send" id="send" class="btn btn-primary hover:opacity-100 hover:text-white">
                                        <i class="fa fa-paper-plane"></i></button>
                                    </div>
                            </div>
                            <input type="hidden"id="chat_username" value ="<?= $username?>">
                            <input type="hidden"id="imagesource" value ="<?= $profileimage; ?>">
                            <div id="validation_error"></div>
                        </form>
                    </div><!-- end of 2nd tab div content -->
                </div><!-- end of Total tab div content -->
            </div><!-- end of chat popup div content -->
          </div>
      </div>
</div>


