@include('config')
@include('minimal_header')
@include('sidebar')

<style>

</style>

</head>
<?php
$id=auth()->id();
?>
<body class="h-100 m-0">
	<div class="container mt-4">
		<div class="row">
			<div class="col-lg-8">
				<div class="card ">
					@include('message')
					<div class="card-header">
                    <div class="row ">
                        <div class="col">
                            <div class=" shadow mb-3" >
                                <div class=" d-flex justify-content-start align-items-center float-right" >
									{{-- <div class="dropdown-list-image mr-5 pr-5 text-center"> --}}
										<img class="rounded-circle d-inline" src="<?= $user->profile_image; ?>" height="35" width="35">
										<h3 class="d-inline"><?= $user->username; ?></h3>
										<div class="dropdown d-inline">
											<span class="btn btn-link btn-sm" data-toggle="dropdown">
												<i class="fas fa-arrow-down text-blue-400"></i>
											</span>
											<div class="dropdown-menu text-blue shadow dropdown-menu-right " role="menu">
												<button class="dropdown-item pt-0 delete " 
														data-element="conversation" 
														data-id="<?= $user->getkey(); ?>" 
														data-action="delete_all" 
														data-sender_id="<?= $user->getkey(); ?>">
														Delete this Conversation
												</button>												
											</div>
										{{-- </div> --}}
									</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
				<div class="card-body overflow-y-auto h-96" id="messages_area">
                <?php foreach ($chat_data as $key => $chat): ?>
                    <?php
                            $float=$row_class='';
                            $background_class =' mb-0 ';
                            if(auth()->id()!=$chat->sender_id){
                                $row_class = ' flex-row-reverse ';
                                $float=' float-right ';
                            }
                    ?>
                    @include('chat_message')
                <?php endforeach ?>
					</div>
					<div class="card-body h-4" >
						<span id="typing_on"></span>
					</div>
				</div>
				<form method="post" id="form" action="<?=route('conversation')?>"
					data-parsley-errors-container="#validation_error">
					<div id="validation_error"></div>
					<div class="input-group mb-3">
						<textarea 
							class="form-control" 
							id="chat_message" 
							name="message" 
							placeholder="Type Message Here" 
							data-parsley-maxlength="1000" 
							rows="3" 
							required></textarea>						
						<div class="input-group-append">
                        <?php $login_user_id=$id;?>
                            <input type="hidden" name="sender_id" id="login_user_id" value="<?= $login_user_id;?>" />
							<input type="hidden"id="chat_username" value ="<?= $username??auth()->user()->username?>">
                            <input type="hidden" name="user_id" id="user_id" value="<?= $user->id;?>" />
							<input type="hidden" name="conversation_id" id="conversation_id" value="<?= $conversation_id;?>" />
							<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
						</div>
					</div>
					
				</form>
			</div>
			<div class="col-lg-4">

				<div class="mt-3 mb-3 text-center">
					<img src="<?= auth()->user()->profile_image;?>" width="100" class="img-fluid rounded-circle img-thumbnail" /><br>
                    <h3 class="d-inline"><?=  auth()->user()->username; ?></h3>
                    <div class="dropdown d-inline">
                        <button class="btn btn-link btn-sm mt-0 pt-0" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v "></i></button>
                        <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in" role="menu">
                            <a class="dropdown-item pt-0 "href="<?= route('user.profileview',$user->id); ?>" >Profile</a>
                        </div>
                    </div>
				</div>
				<div class="card mt-3">
					<div class="card-header text-center">User List</div>
					<div class="card-body h-60 p-0 overflow-y-auto" id="user_list">
						<div class="list-group list-group-flush">					
						@if(count($user_data) > 0)
							@foreach($user_data as $key => $chatuser)							
								@if($chatuser['id'] != $login_user_id)
									<a class="list-group-item list-group-item-action" href="{{route('conversation',$chatuser['id'])}}">
										<img src="{{$chatuser->profile_image}}" class="img-fluid rounded-circle img-thumbnail" width="50" />
										<span class="ml-1"><strong>{{$chatuser["username"]}}</strong></span>
										<span class="mt-2 float-right">											
											@if($chatuser['login'] == 'home')
												<i class="fa fa-circle text-success"></i>
											@else
												<i class="fa fa-circle text-danger"></i>
											@endif	
										</span>
									</a>
								@endif
							@endforeach						
						@endif						
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</body>
@include('minimal_footer')
@include('footer_script')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script type="text/javascript">
var user_id=$('#user_id').val();
var login_user_id=$('#login_user_id').val();
var pusher=new Pusher('fe405ac1069716ad12b6',{cluster:'eu'});
//define the channel to listen to
var channel=pusher.subscribe(`chat-message${user_id}`);

//bind and listen to the event
	channel.bind('ChatMessage',function(response){
		processResponse(response)
	})
		
       $("html, body,#messages_area").animate({ scrollTop: $(document).height() }, 1000);

	function update(data,response){
        $('#messages_area').append(response.update);
		if ("conversation_id" in response && response.conversation_id){
            $(`#conversation_id`).val(response.conversation_id);
        }
    }

	
</script>
<script type="text/javascript" src="<?= JS_URL?>user_action.js" ></script>
</html>

