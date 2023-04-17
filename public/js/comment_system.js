 $(document).ready(function(){
    // When user clicks on submit comment to add comment under
    var last_received_text;
    var object;
    var object_id;
	$(document).on('click', '.submit_comment', function(e) {
		e.preventDefault();
		let post_id=$(this).data('id');
        let comment_text = $('#comment_text_'+post_id).val();
		// preventing same text to be sent twice or preventing empty text to be sent
        if(comment_text==last_received_text||comment_text == ""){
            $('.comment_text').val('');
            return
        }
		// if not same then store it into last received variable
        last_received_text=comment_text;
		var url = $('.comment_form').attr('action');
		var receiver_id=$(this).data('user_id');
      //  alert(url)
       // alert(comment_text)
      //  alert(receiver_id)
		$.ajax({
			url: url,
			method: "POST",
			data: {
				body: comment_text,
				post_id:post_id,
				receiver_id:receiver_id,
			},
            dataType:"JSON",
            complete: function(){
                $('.reply-btn').show();
                $('.delete-btn').show();
                last_received_text=''
            },
			success: function(data){
				if ('error'in data && data.error!= "") {
					showAlert(data.error);
				} else {
					$('.comment_text').val('');
					$('#comments-wrapper_'+post_id).prepend(data.comment);
					$('#comments_count_'+post_id).text(data.comments_count+' Comment'+(data.comments_count>1?'s':''));
                    $('#comment_call_'+post_id).hide();
				}
			}
		});
	});

// When user clicks on edit comment
$(document).on('click', '.edit-btn', function(e){
		e.preventDefault();
		// Get the comment id from the edit button's data-id attribute
        var object_id = $(this).data('id');
        var comment_id=$(this).data('parent_id');
        object=$(this).data('object');
        //alert(comment_id)
		$edit_comment = $(this).parent();
        // grab the comment to be edited
        var comment = $(this).siblings('.comment_value').text();
        //alert(comment)
		$('.comment-details').show();
        // place comment in form
		$('.reply_text').val(comment);
		$('.comment_info').show();
		$edit_comment.hide();
		$('#profilepic_'+comment_id).show();
		$('.reply_form').hide();
		$('#comment_reply_form_'+comment_id).show();
		$('.submit-reply').hide();
		$('.update-reply').show();

	$(document).on('click', '.update-reply', function(e){
		e.preventDefault();
        // elements
        $clickedbutton=$(this);
		var comment_id = $clickedbutton.data('id');
		$childform=$clickedbutton.parent('#comment_reply_form_'+comment_id);
		$childtext=$clickedbutton.siblings('#reply_text_'+comment_id);
        var comment_text = $childtext.val();
        if(comment_text==last_received_text||comment_text == ""){
            $('.comment_text').val('');
            return
        }
        last_received_text=comment_text;
        var url = $(this.form).attr('action');
        finalurl=url+'/'+object+'/update'
       // alert(finalurl)
       // alert(object_id)
		$.ajax({
			url:finalurl,
			method: "POST",
			data: {
				'id': object_id,
				'body': comment_text,
			},
            dataType:"JSON",
            complete: function(){
                $('.reply-btn').show();
                $('.delete-btn').show();
                last_received_text=''
            },
			success: function(data){
				if ('error'in data && data.error!= "") {
                    showAlert(data.error);
					$edit_comment.show();
				} else {
					$edit_comment.replaceWith(data.response);
					$childtext.val('');
                    $childform.hide();
				}
			}
		});
	});
});

	// When user clicks on submit reply to add reply under comment
	$(document).on('click', '.reply-btn', function(e){
		e.preventDefault();
		$('.comment_info').show();
        var comment_id = $(this).data('id');
        object=$(this).data('object');
		$('.reply-btn').show();
		$('.delete-btn').show();
		$(this).siblings('.delete-btn').hide();
		$(this).hide();
		$('.reply_text').val('');
		$('.reply_form').hide();
		$('#comment_reply_form_'+comment_id).toggle();
		$('.submit-reply').show();
		$('.update-reply').hide();


		$(document).on('click', '.submit-reply', function(e){
			e.preventDefault();
			var comment_id = $(this).data('id');
			var receiver_id=$(this).data('receiver_id');
			var reply_textarea =$('#reply_text_'+comment_id); // reply textarea element
			var reply_text = reply_textarea.val();
            var url = $(this).parent().attr('action');
            finalurl=url+'/replies'
			$.ajax({
				url: finalurl,
				method: "POST",
				data: {
					comment_id: comment_id,
					receiver_id:receiver_id,
					body: reply_text,
				},
                dataType:"JSON",
                complete: function(){
                    $('.reply-btn').show();
                    $('.delete-btn').show();
                    last_received_text=''
                },
				success: function(data){
                    if ('error'in data && data.error!= "") {
                        showAlert(data.error);
                    }
					else {
                        reply_textarea.val('');
                        $('.replies_wrapper_'+comment_id).append(data.response);
                        $('.reply_form').hide();
					}
				}
			});
		});
	});


// When user clicks on cancel reply button
$(document).on('click', '.cancel-btn', function(e){
		e.preventDefault();
		$('.reply_text').val('');
		$('.reply_form').hide();
		$('.comment_info,.comment-details').show();
		$('.reply-btn').show();
		$('.delete-btn').show();
	});

// When user clicks on delete reply under comment
$(document).on('click', '.delete-btn', function(e){
	e.preventDefault();
	// Get the comment id from the button's data-id attribute
	var comment_id = $(this).data('id');
	object=$(this).data('object');
	var parent_id = $(this).data('parent_id');
    $clickedbutton=$(this);
    $comment=$clickedbutton.closest('div.commentbox');
    url=$('#action_server').val();
    finalurl=url+'/'+object+'/delete'
   // alert(finalurl)
		$.ajax({
			url: finalurl,
			method: "POST",
			data: {
				'id': comment_id,
				'object': object,
				'post_id': parent_id,
			},
			dataType:"JSON",
			beforeSend: function(){
				$comment.fadeOut('slow');
			   },
			success: function(data){
                if ('error'in data && data.error!= "") {
                    showAlert(data.error);
                    $comment.show();
                }
				 else {
                        if ('response'in data ) {
                           $('#comments_count_'+post_id).text(data.response+' Comment'+(data.response>1?'s':''));
                            $comment.remove();
                            if (data.response==0){
                            $('#comments-wrapper_'+post_id).append('<h2 id="comment_call">Be the first to comment on this post</h2>').show();
					    }
                    }
				}
			}
		});
	});






 // if the user clicks on the follow button
 $(document).on('click', '.comments_count', function(e){
    e.preventDefault();
    var path=$(this).parent();
    var form=path.siblings('form.comment_form');
    var comments_wrapper=path.siblings('.comments-wrapper');
    var comment=comments_wrapper.children('.comment');
    var comment_call=comments_wrapper.find('.comment_call');
    $('.comment').hide();
    $(comment).show();
    $('.comment_form').hide()
    $(form).show();
    $('.comment_call').show();
    comment_call.hide();
    $('.comments_count').show();
    $(this).hide();
  });





});
