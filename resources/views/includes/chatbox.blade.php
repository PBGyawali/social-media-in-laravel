
<div class="container d-none d-sm-block">
    <div class="row">
        <div class=" col xs-0 col sm-0 col-md-12">
            <button class="open-button cursor-pointer bg-white position-fixed
                rounded-circle z-50 text-7xl opacity-80 hover:opacity-100 hover:text-white focus:outline-none no-shadow bottom-6 right-6">
                <i class="chatboxicon text-dark fa fa-comments fa-1x"></i>
            </button>
            <div class="chat-popup position-fixed  d-none z-50 mb-5 right-0 bottom-7" id="chatbox">
                <ul class="nav nav-tabs" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <span class="nav-link active text-decoration-none tabbutton d-flex justify-content-between  align-items-end" data-id="ex1-tabs-0" data-mdb-toggle="tab" >Message</span>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link tabbutton" data-id="ex1-tabs-1" data-mdb-toggle="tab" role="tab" >Support</a>
                    </li>
                </ul>
                @auth
                <!-- Tabs content -->
                <div class="tab-content w-80 max-w-sm bottom-7" id="ex1-content">
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
                                                            <?php if($user->getKey() != auth()->id()):?>
                                                        <a href="{{route('conversation',$user->getKey())}}"
                                                             data-profile="{{route('user.profileview',$user->getKey())}}"
                                                             data-id="{{$user->getKey()}}"
                                                             class="list-group-item-action chatbox-user-list">
                                                                <img src="<?= $user->profile_image?>"
                                                                class="img-fluid rounded-circle img-thumbnail chatbox-user-image" width="50" />
                                                                <span class="ml-1 chatbox-username"><strong><?=$user->username ?></strong></span>
                                                                <span class=" ml-1 mt-2 float-right"><i class="fa fa-circle text-<?=
                                                                $user->is_online()?'success':'danger';?>"></i></span>
                                                        </a>
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
                    @endauth
                    <div class="tab-pane show " id="ex1-tabs-1" role="tabpanel" >
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col h-40 user-chat-content overflow-y-auto ">
                                            <div class="chat-heading">
                                                <i class="fas fa-comment chatboxicon p-0"></i> Support: 
                                            </div>
                                            <span class="usermessage">
                                                Hello <?= $username??auth()->user()->username?>. What can we do for you?
                                            </span>
                                            <p>
                                                <span class="usermessagedate" id="usermessagedate"></span>
                                            </p>                                            
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col h-2 text-center">                                            
                                            <span class="typing_on"id="typing_on"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="post" action="{{route('conversation.store')}}"id="form" class="chat form-container p-0 text-base bg-none opacity-80 w-80 max-w-sm" data-parsley-errors-container="#validation_error">
                            <div class="input-group mb-3">
                                    <textarea  id="sender_msg" name="message" placeholder="Type Message Here"
                                    class="msg form-control bg-secondary text-white focus:outline-black sender_msg" autocomplete="off"
                                    data-parsley-trigger="keyup" required></textarea>
                                    <div class="input-group-append">
                                        <button type="submit" name="send" id="send" class="btn btn-primary hover:opacity-100 hover:text-white">
                                        <i class="fa fa-paper-plane"></i></button>
                                    </div>
                            </div>
                            <input type="hidden"id="chat_username" class="chat_username" value ="<?= $username??auth()->user()->username?>">
                            <input type="hidden" name="sender_id" id="loggedin_user_id" value="{{auth()->id()}}" />
							<input type="hidden"id="chat_username" value ="<?= $username??auth()->user()->username?>">
                            <input type="hidden"name="conversation_id"id="conversation_id" value ="<?= $username??auth()->user()->username?>">
                            <input type="hidden" name="user_id" id="user_id" value="" />
                            <input type="hidden"id="imagesource" class="chat_image" value ="<?= $profileimage??auth()->user()->profile_image; ?>">
                            <div id="validation_error"></div>
                        </form>
                    </div><!-- end of 2nd tab div content -->
                </div><!-- end of Total tab div content -->
            </div><!-- end of chat popup div content -->
          </div>
      </div>
</div>


