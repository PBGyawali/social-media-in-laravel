
  var messageBox = $('#sender_msg,#chat_message');
  var username = $("#chat_username").val();
  var src=$("#imagesource").val();
  var typingStatus = $('#typing_on');
  var lastTypedTime = new Date(0).getTime();
  var time=getDate(true);
  var delay = 8000; //typing delay time in milliseconds


$('.tabbutton').on('click', function(event){
    event.preventDefault();
    var tabpane=$(this).data('id');
    $('.tabbutton').removeClass('active');
    $(this).toggleClass('active');
    $('.tab-pane').hide();
    $('#'+tabpane).show();
    $('.minimize').html('^');
    $("#usermessagedate").text(getDate(true));
});

$('.open-button').on('click', function(event){
  $('#chatbox').toggleClass('d-none');
});
function refreshTypingStatus(){
  return
  if (!messageBox.is(':focus') || currentTime() - lastTypedTime > delay){
    typingInfo='Last online '+lastTypedTime;
  }
  if ( !messageBox.val() ){
    typingInfo=' ';
  }
    else{
      typingInfo=username+' is typing...';
    }
   // typingStatus.html(typingInfo);
   if(url){
    finalurl=url+'/typing';
    sendData={sender_id:$('#login_user_id').val(),message:typingInfo}
    ajaxCall(finalurl,sendData)
   }
    
}
  function updateLastTypedTime(){
      lastTypedTime = currentTime();
  }

  function currentTime(){
    return new Date().getTime();
  }

  setInterval(refreshTypingStatus, 30000);
  messageBox.keypress(updateLastTypedTime);
  messageBox.blur(refreshTypingStatus);

  function getDate(time=null) {
      var date;
      date = new Date();
      if(time)
        return date.toLocaleString([], { hour: 'numeric', minute: 'numeric' });
      return  date.toLocaleString();
  }
 
  

    // if the user clicks on the ratings button ...
    $(document).on('click', '.rating-btn', function(){
      var data="Sorry you need to login to perform this action";
      var user_id= $(this).data('user_id');
      if (!user_id|| !$.isNumeric(user_id))
      {
        showAlert(data);
        return false;
      }
      var receiver_id=$(this).data('receiver_id');
      //var Class = $(this).attr("class");
      var post_id = $(this).data('id');
      var url=$('#rating_server').val();
      $clicked_btn = $(this);
      $likes=$clicked_btn.siblings('span.likes');
      $dislikes=$clicked_btn.siblings('span.dislikes');
      $sibling=$clicked_btn.siblings('i');
      var totallikes=$likes.text();
      var totaldislikes=$dislikes.text();
      var clicked_btnclass= $clicked_btn.attr("class");
      var siblingclass=$sibling.attr("class");
        if ($clicked_btn.hasClass('fa-thumbs-o-up'))
        {
          action = 'like';
          $clicked_btn.removeClass('fa-thumbs-o-up').addClass('text-primary');
          // change button styling of the other button if user is reacting the second time to post
          if (totaldislikes!=0 && $sibling.hasClass('text-primary'))
          {
            $dislikes.text(totaldislikes*1-1);
          }
          $sibling.removeClass(' text-primary').addClass('fa-thumbs-o-down');
          $likes.text(totallikes*1+1);
        }
        else if ($clicked_btn.hasClass('fa-thumbs-o-down'))
        {
          action = 'dislike';
          $clicked_btn.removeClass('fa-thumbs-o-down').addClass('text-primary');
          if (totallikes!=0  && $sibling.hasClass('text-primary'))
          {
            $likes.text(totallikes*1-1);
          }
          $sibling.removeClass(' text-primary').addClass('fa-thumbs-o-up');
          $dislikes.text(totaldislikes*1+1);
        }
        else if($clicked_btn.hasClass('fa-thumbs-up', 'text-primary'))
        {
          action = 'unlike';
          $clicked_btn.removeClass('text-primary').addClass('fa-thumbs-o-up');
          if (totallikes!=0)
          {
            $likes.text(totallikes*1-1);
          }
        }
        else if($clicked_btn.hasClass('fa-thumbs-down', 'text-primary'))
        {
          action = 'undislike';
          $clicked_btn.removeClass(' text-primary').addClass('fa-thumbs-o-down');
          if (totaldislikes!=0)
          {
            $dislikes.text(totaldislikes*1-1);
          }
        }
        let sendData= {'rating_action': action,'receiver_id':receiver_id,'post_id': post_id};
        ajaxCall(url,sendData).then(function(response){
            // display the number of likes and dislikes
            $likes.text(response.likes);
            $dislikes.text(response.dislikes);
        }).catch(function(error){
          data="Sorry user reaction on this post cannot accepted at the moment";
          showAlert(data);
          $clicked_btn.attr('class',  clicked_btnclass);
          $sibling.attr('class',  siblingclass);
          $likes.text(totallikes);
          $dislikes.text(totaldislikes);
        })

      
    });


        // if the user clicks on the follow button
        $(document).on('click', '.action_button', function(){
          var receiver_id = $(this).data('receiver_id');
          var sender_id= $(this).data('user_id');
          var url=$(this).data('url');
          var data="Sorry, You cannot follow yourself";
          if (!sender_id|| !$.isNumeric(sender_id))
            {
              var data="Sorry you need to login to perform this action";
              showAlert(data);
              return false;
            }
          if (receiver_id==sender_id){
            showAlert(data);
            return false;
          }
          $clickedbtn=$(this);
          var status=$(this).text();
          if (status=='Follow') {
              result = 'follow';
              $(this).html('Following').addClass('btn-success').removeClass('btn-primary');
          } else if(status=='Following'|| status=='UnFollow'){
            result = 'unfollow';
              $(this).html('<i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow').removeClass('btn-success').addClass('btn-primary');
          }
          let sendData= {'result': result,'receiver_id': receiver_id};
            ajaxCall(url,sendData).then(function(data){
              if ('error' in data && data.error)
              {
                  showAlert(data.error);
                  $clickedbtn.text(status);
              }
            }).catch(function(){
              data="Sorry the user cannot be followed at the moment";
              showAlert(data);
            })
        });

          // if the user clicks on the message button
          $(document).on('click', '.send_message_button,.chatbox-user-list', function(e){
            e.preventDefault();
            const id=$(this).data('id');
            const sender_id= $(this).data('sender_id');
            if (this.hasAttribute('data-sender_id')&&(!sender_id|| !$.isNumeric(sender_id)))
              {
                var data="Sorry you need to login to perform this action";
                showAlert(data);
                return false;
              }            
            const link=$(this).attr('href');       
            const profileLink=$(this).data('profile');
            $imageDiv=$(this).find('.chatbox-user-image');
            if(!$imageDiv.length)
            $imageDiv=$('.profile-user-image');
            $image=$imageDiv.clone().attr('width',40);
            $chatUsernameDiv=$(this).find('.chatbox-username');
            if(!$chatUsernameDiv.length)
            $chatUsernameDiv=$('.profile-username');
            const chatUsername=$chatUsernameDiv.text();
            $chatbox=$('#chatbox').clone();
            $chatbox.removeClass().attr('id',`chatbox${id}`).addClass('mr-2')
            $chatbox.find('ul li:not(:first)').remove();
            $chatbox.find('ul li:first').addClass('w-100');
            $buttons=`<span>
                            <button type="button" data-id="${id}" id="minimize${id}"class="minimize mr-1 fa-2x d-inline p-0 badge" aria-label="minimize">
                                -
                            </button>        
                            <button type="button" data-id="${id}" class="close d-inline p-0 m-0" aria-label="Close">
                                <span>&times;</span>
                            </button>
                      </span>                    
                        `;
            $template=
            `<span class="dropdown">
                <a class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown">
                    ${$image.prop('outerHTML')} ${chatUsername}</a>
                <div class="dropdown-menu shadow dropdown-menu-left"
                    role="menu">
                    <a href="${link}"class="dropdown-item" role="presentation" > View Full</a>
                    <button class="dropdown-item delete" data-element="conversation" data-id="${id}" 
                    data-action="delete_all" data-sender_id="${id}">Delete Conversation</button>
                    <a href="${profileLink}" class="dropdown-item " role="presentation" >View Profile</a>
                </div>
            </span> `
            if(!profileLink)
            $template=`<span><a class="btn btn-link btn-sm" >${$image.prop('outerHTML')} ${chatUsername}</a></span>`
            $chatbox.find('.tabbutton').addClass('chattabbutton').html('').append($template).append($buttons).attr('id',`tabbutton${id}`).attr('data-id',id); 
            $chatbox.find('.tab-pane:first').remove();
            $chatbox.find('.tab-pane').addClass('active').attr('id',`tab-pane${id}`);  
            $chatbox.find('.user-chat-content').html('').attr('id',`user-chat-content${id}`);
            $chatbox.find('.typing_on').attr('id',`typing_on${id}`);      
            $chatbox.find('.chat_username').val(chatUsername)
            $chatbox.find('input[name="user_id"]').val(id)
            $chatbox.find('.chat_image').val($image.attr('src'))
            
            if(!$(`#chatbox${id}`).length){
                $('.chatbox-content').append($chatbox);
               if(link){
                    ajaxCall(link,id,'get').then(function(result){
                        $(`#chatbox${id}`).remove();
                        $chatbox.find('.user-chat-content').html(result.chatview);
                        $chatbox.find('input[name="conversation_id"]').val(result.conversation_id).attr('id','conversation_id'+id)
                        $('.chatbox-content').append($chatbox);
                    })
                }
            }        
            else{            
                $(`#chatbox${id}`).addClass('highlighted').find('.tabbutton').removeClass('position-fixed bottom-0').addClass('active')
                
                setTimeout(function(){
                    $(`#chatbox${id}`).removeClass('highlighted');
                }, 1000)
            }
            if($(`#tab-pane${id}`).is(':hidden')){
                    $(`#tab-pane${id}`).show()
                    $(`#minimize${id}`).html('-')
            }
             
          });

          $(document).on('click','.close',function(e){
            e.preventDefault();
            const id=$(this).data('id');
            $(this).closest('div').remove();
        })
    
        $(document).on('click','.minimize',function(e){
            e.preventDefault();
            const button=$(this);
            const id=button.data('id');
            $(`#tab-pane${id}`).toggle();
            $('.chattabbutton').each(function(){
                var buttonId=$(this).data('id');
                if($(`#tab-pane${buttonId}`).is(':hidden')){
                    $(`#tabbutton${buttonId}`).addClass('position-fixed bottom-0');
                    $(`#minimize${buttonId}`).html('^')
                }
                else{
                    $(`#tabbutton${buttonId}`).removeClass('position-fixed bottom-0').addClass('active');
                    $(`#minimize${buttonId}`).html('-')
                };
            })
        });

