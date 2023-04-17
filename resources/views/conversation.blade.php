@include('config')
@include('minimal_header')
@include('sidebar')
<?php
$id=auth()->id();
?>
</head>
<body class="h-100 m-0">
	<div class="container mt-4">
		<div class="row">
			<div class="col-lg-8">
				<div class="card text-center">
					<div class="card-header text-center">
                    <div class="row ">
                        <div class="col text-center">
                            <div class=" shadow mb-3 text-center " >
                                <div class=" d-flex justify-content-between align-items-center text-center float-right" >
                                <div class="dropdown-list-image mr-5 pr-5 text-center">
                                    <img class="rounded-circle d-inline" src="<?= $user->profile_image; ?>" height="35" width="35">
                                    <h3 class="d-inline"><?= $user->username; ?></h3>
                                    <div class="dropdown d-inline">
                                        <span class="btn btn-link btn-sm" data-toggle="dropdown"><i class="fas fa-arrow-down text-blue-400"></i></span>
                                        <div class="dropdown-menu text-blue shadow dropdown-menu-right " role="menu">
                                            <a class="dropdown-item pt-0 " data-id="<?= $user->id; ?>">Delete this Conversation</a>
                                        </div>
                                     </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
				<div class="card-body bg-secondary overflow-y-auto h-96" id="messages_area">
                <?php foreach ($chat_data as $key => $chat): ?>
                    <?php
                            $float=$row_class='';
                            $background_class =' mb-0 ';
                            if($id!=$chat->sender_id){
                                $row_class = ' flex-row-reverse ';
                                $background_class = ' mb-0 ';
                                $float=' float-right ';
                            }
                    ?>
                    @include('chat_message')
                <?php endforeach ?>
					</div>
				</div>
				<form method="post" id="form" action="<?=route('conversation')?>"data-parsley-errors-container="#validation_error">
					<div class="input-group mb-3">
						<textarea class="form-control" id="chat_message" name="message" placeholder="Type Message Here" data-parsley-maxlength="1000" rows="3" required></textarea>
						<div class="input-group-append">
                        <?php $login_user_id=$id;?>
                            <input type="hidden" name="sender_id" id="login_user_id" value="<?= $login_user_id;?>" />
                            <input type="hidden" name="user_id" id="user_id" value="<?= $user->id;?>" />
							<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
						</div>
					</div>
					<div id="validation_error"></div>
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
						<?php
						if(count($user_data) > 0){
							foreach($user_data as $key => $chatuser){
								$icon = '<i class="fa fa-circle text-danger"></i>';
								if($chatuser['login'] == 'home')
									$icon = '<i class="fa fa-circle text-success"></i>';
								if($chatuser['id'] != $login_user_id){
									echo '<a class="list-group-item list-group-item-action" href="'.route('conversation').'/'.$chatuser['id'].'">
										<img src="' .$chatuser->profile_image.'" class="img-fluid rounded-circle img-thumbnail" width="50" />
										<span class="ml-1"><strong>'.$chatuser["username"].'</strong></span>
										<span class="mt-2 float-right">'.$icon.'</span></a>';
								}
							}
						}
						?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</body>
@include('minimal_footer')
<script type="text/javascript">

		var conn = new WebSocket(' ws://127.0.0.1');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
		    console.log(e.data);
		    var data = JSON.parse(e.data);
		    var row_class = '';
		    var background_class = '';
		    if(data.from == 'Me')
		    {
		    	row_class = 'row justify-content-start';
		    	background_class = 'text-dark alert-light';
		    }
		    else
		    {
		    	row_class = 'row justify-content-end';
		    	background_class = 'alert-success';
		    }
            var html_data = '<div class="'+row_class+'">';
            html_data+='<div class="col-sm-10">'
            html_data+='<div class="shadow-sm alert'+background_class+'">';
            html_data+='<b>'+data.from+'" - </b>'+data.msg+'<br />';
            html_data+='<div class="text-right"><small><i>'+data.dt+'</i></small></div></div></div></div>';

		    $('#messages_area').append(html_data);
		    $("#chat_message").val("");
		};

		$('#chat_form').parsley();
       $("html, body,#messages_area").animate({ scrollTop: $(document).height() }, 1000);
		$('#chat_form').on('submit', function(event){
			event.preventDefault();
			if($('#chat_form').parsley().isValid())
			{
				var user_id = $('#user_id').val();
                var message = $('#chat_message').val();
               // alert(user_id)
                return
				var data = {
					user_id : user_id,
					message : message
                };
				conn.send(JSON.stringify(data));
                $("#messages_area").animate({ scrollTop: $(document).height() }, 1000);
			}
		});
	function update(data){
        $('#messages_area').append(data);
    }
    function destroy(id){
        //alert(id)
        $('#chatmessage_'+id).remove();
    }
</script>
</html>
@include('footer_script')
