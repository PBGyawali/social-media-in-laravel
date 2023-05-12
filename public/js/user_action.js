
  var msg = $('#sender_msg');
  var username = $("#chat_username").val();
  var src=$("#imagesource").val();
  var typingStatus = $('#typing_on');
  var lastTypedTime = new Date(0);
  var time=getDate();
  var delay = 8000; //typing delay time in milliseconds


$('.tabbutton').on('click', function(event){
    event.preventDefault();
    var tabpane=$(this).data('id');
    $('.tabbutton').removeClass('active');
    $(this).toggleClass('active');
    $('.tab-pane').hide();
    $('#'+tabpane).show();
    $("#usermessagedate").text(getDate(true));
});

$('.open-button').on('click', function(event){
  $('#chatbox').toggleClass('d-none');
    var sender_id=$(this).data('sender_id');
    var receiver_id= $(this).data('id');
    var receiver_type=$('#receiver_type').val();
});
function refreshTypingStatus(){
  if (!msg.is(':focus') || msg.val() == '' || new Date().getTime() - lastTypedTime.getTime() > delay)
      typingStatus.html('');
    else
      typingStatus.html(username+' is typing...');
}
  function updateLastTypedTime(){
      lastTypedTime = new Date();
  }

  setInterval(refreshTypingStatus, 500);
  msg.keypress(updateLastTypedTime);
  msg.blur(refreshTypingStatus);

  function getDate(time=null) {
      var date;
      date = new Date();
      if(time)
        return date.toLocaleString([], { hour: 'numeric', minute: 'numeric' });
      return  date.toLocaleString();
  }
  function chatmsg(id=1,src,username,txt,iconclass,time=null){
      new_id=id*1+1;
      $('#newusermessage_'+id).remove();
      var chat_msg=	'<div id="newusermessage_'+new_id+'">'+
                  '<div>'+
          '<img src="'+src+'" class="rounded-circle mb-0 mt-0" height="30" width="30"> '+ username+":"+
            '</div>'+ '<div>'+
          '<span class="usermessage_1">'+txt+' <i class="fas fa-'+iconclass+'"</i></span>'+'</div>'+
          '<p><span class="ticketcommentdate">'+'<time class="chattimeago" datetime="'+time+'">'+time+'</time></span></p>';
          $('#all_messages').append(chat_msg);
    }
    $('#chat').on('submit', function(event)
    {     var url=$('#user_message_server').val();
          var g=new Date();
          event.preventDefault();
          var sender_id=$('#sender_id').val();
          var receiver_id=$('#receiver_id').val();
          var time=getDate();
          var txt = $("#sender_msg").val();
          if (txt==""){
            alert('the text is empty');
            return false;
          }
          var username = $("#chat_username").val();
          chatmsg(1,src,username,txt,'pause-circle  text-primary',time);
          $.ajax
          ({
              url:url,
              method:"POST",
              data:{image:src, username:username,text:txt,sender_id:sender_id,
                receiver_id:receiver_id,user_message:1},
              dataType:"JSON",
              beforeSend:function(){
                chatmsg(1,src,username,txt,'clock text-warning',time);
              },
              error:function(){
                chatmsg(2,src,username,txt,'times text-danger unsent',time);
              },
                success:function(data)  {
                $('#newusermessage_1,#newusermessage_2,#newusermessage_3').remove();
                $('#all_messages').append(data);
              },
              complete:function() {
                $("#sender_msg").val('');
              },
            })
    });

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

        $.ajax
        ({
            url: url,
            method: 'POST',
            data: {
                    'rating_action': action,
                    'receiver_id':receiver_id,
                    'post_id': post_id
                  },
            dataType:"JSON",
            error:function()
            {
              data="Sorry user reaction on this post cannot accepted at the moment";
              showAlert(data);
              $clicked_btn.attr('class',  clicked_btnclass);
              $sibling.attr('class',  siblingclass);
              $likes.text(totallikes);
              $dislikes.text(totaldislikes);
            } ,
            success: function(response)
            { // display the number of likes and dislikes
              $likes.text(response.likes);
              $dislikes.text(response.dislikes);
            }
        });
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
          var r=$(this).text();
          if (r=='Follow') {
              result = 'follow';
              $(this).html('Following').addClass('btn-success').removeClass('btn-primary');
          } else if(r=='Following'|| r=='UnFollow'){
            result = 'unfollow';
              $(this).html('<i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow').removeClass('btn-success').addClass('btn-primary');
          }

          $.ajax({
              url: url,
              method: 'post',
              data: {
                  'result': result,
                  'receiver_id': receiver_id},
              dataType:"JSON",
              error:function()
                   {  data="Sorry the user cannot be followed at the moment";
                   showAlert(data);
                     } ,
              success: function(data){

                if ('error' in data && data.error)
                {
                    showAlert(data.error);
                    $clickedbtn.text(r);
                }
            }
          });
        });

          // if the user clicks on the message button
          $(document).on('click', '.send_message_button', function(){
           var receiver_id = $(this).data('receiver_id');
            var sender_id= $(this).data('sender_id');
            var chatbox='';
            var receiver_type=  $(this).data('receiver_type');
            if (receiver_type=="user"){
              $('#usermessage_0').hide();
              $('#chatbox_heading').text('Message');
            }
            else{
              $('#usermessage_0').show();
              $('#chatbox_heading').text('Support');

            }
            if (sender_id == ''|| !$.isNumeric(sender_id))
              {
                var data="Sorry you need to login to perform this action";
                showAlert(data);
                return false;
              }
              $('#receiver_type').val(receiver_type);
              $('#sender_id').val(sender_id);
              $('#receiver_id').val(receiver_id);
              $('#chatbox').toggleClass('d-none');

          });

