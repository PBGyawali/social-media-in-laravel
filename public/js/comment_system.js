 $(document).ready(function(){
    // When user clicks on submit comment to add comment under
    var object;
	var lastReceivedText;

	function submitAction(){
		$('.delete-btn,.reply-btn').show();		
		lastReceivedText='';
		$('.reply_text').val('');
		$('.reply_form').hide();
        $('.comment_info,.comment-details').show();
	}

	function checkAction(commentText) {
		return new Promise((resolve, reject) => {
			if (commentText == lastReceivedText || !commentText) {
				$('.comment_text').val('');
				reject();
			} else {
				lastReceivedText = commentText;
				resolve(commentText);
			}
		});
	}
	   // When user clicks on cancel reply button
	$(document).on('click', '.cancel-btn', function(e) {
        e.preventDefault();        
		submitAction()
    });

	// if the user clicks on the follow button
	$(document).on('click', '.comments_count', function(e){
		e.preventDefault();
		var path=$(this).parent();
		var form=path.siblings('form.comment_form');
		var comments_wrapper=path.siblings('.comments-wrapper');
		var comment=comments_wrapper.children('.comment');
		var comment_call=comments_wrapper.find('.comment_call');
		$('.comment,.comment_form').hide();
		$('.comment_call,.comments_count').add(form).add(comment).show();
		$(this).add(comment_call).hide();	
	});

	$(document).on('click', '.submit_comment', function(e) {
        e.preventDefault();
        let postID = $(this).data('id');
        let commentText = $('#comment_text_' + postID).val();
        submitComment(postID, commentText);
    });	
	
	function submitComment(postID, commentText) {
		checkAction(commentText).then(function(){
			var url = $('.comment_form').attr('action');
			var receiverID = $(this).data('user_id');
			let sendData = { body: commentText, post_id: postID, receiver_id: receiverID };
			ajaxCall(url, sendData)
            .then(function(data) {
                $('.comment_text').val('');
                $('#comments-wrapper_' + postID).prepend(data.comment);
                $('#comments_count_' + postID).text(data.comments_count + ' Comment' + (data.comments_count > 1 ? 's' : ''));
                $('#comment_call_' + postID).hide();
            })
            .then(function() {
				submitAction()
            });
		}).catch(error=>{
			return false;
		})
    }
// When user clicks on edit comment
$(document).on('click', '.edit-btn', function(e){
		e.preventDefault();
		// Get the comment id from the edit button's data-id attribute
        var object_id = $(this).data('id');
        var commentID=$(this).data('parent_id');
        object=$(this).data('object');
		$edit_comment = $(this).parent();
        // grab the comment to be edited
        var comment = $(this).siblings('.comment_value').text();
    
		$('.comment-details').show();
        // place comment in form
		$('.reply_text').val(comment);
		$('.comment_info').show();
		$edit_comment.hide();
		$('#profilepic_'+commentID).show();
		$('.reply_form').hide();
		$('#comment_reply_form_'+commentID).show();
		$('.submit-reply').hide();
		$('.update-reply').show();
		$('.delete-btn,.reply-btn').show();
	$(document).on('click', '.update-reply', function(e){
		e.preventDefault();
        $button=$(this);
		var commentID = $button.data('id');
		$childform=$button.parent('#comment_reply_form_'+commentID);
		$replyTextarea=$button.siblings('#reply_text_'+commentID);
        var commentText = $replyTextarea.val();
		var url = $(this.form).attr('action');
		checkAction(commentText).then(function(){
			finalurl=url+'/'+object+'/update'
			let sendData={'id': object_id,'body': commentText};
			ajaxCall(finalurl, sendData).then(function(data) {
				if ('error'in data && data.error) {
					showAlert(data.error);
					$edit_comment.show();
				} else {
					$edit_comment.replaceWith(data.comments);
					$replyTextarea.val('');
					$childform.hide();
				}
			}).then(function() {
				submitAction()
            });
		});       
	});
});

function submitReply(commentID, receiverID, replyTextarea, object,url) {
	var commentText = replyTextarea.val();
	//var url = $('.comment_form').attr('action');
	var finalURL = url + '/replies';
	let sendData = { comment_id: commentID, receiver_id: receiverID, body: commentText };
	ajaxCall(finalURL, sendData)
		.then(function(data) {
			replyTextarea.val('');
			$('.replies_wrapper_' + commentID).append(data.comments);
			$('.reply_form').hide();
		})
		.then(function() {
			submitAction()
		});
}
	
	// When user clicks on delete reply under comment
	$(document).on('click', '.delete-btn', function(e) {
		e.preventDefault();
		$button=$(this);
		var commentID = $button.data('id');
		object = $button.data('object');
		var parentID = $button.data('parent_id');		
    	$comment=$button.closest('div.commentbox');
		deleteComment(commentID, object, parentID,$comment);
	});

	function deleteComment(commentID, object, parentID,$comment) {
		//var comment = $('#comment_' + commentID);
		var url = $('#action_server').val();
		var finalURL = url + '/' + object + '/delete';
		let sendData = { 'id': commentID, 'object': object, 'post_id': parentID };
		$comment.fadeOut('slow');
		//comment.fadeOut('slow');
		ajaxCall(finalURL, sendData)
			.then(function(data) {
				if ('error' in data && data.error != '') {
					showAlert(data.error);
					$comment.show()
					//comment.show();
				} else {
					if ('commentsCount' in data) {
						$('#comments_count_' + postID).text(data.commentsCount + ' Comment' + (data.commentsCount > 1 ? 's' : ''));
						$comment.remove();
						//comment.remove();
						if (data.commentsCount == 0) {
							$('#comments-wrapper_' + postID).append('<h2 id="comment_call">Be the first to comment on this post</h2>').show();
						}
					}
				}
			});
	}

		// When user clicks on submit reply to add reply under comment
		$(document).on('click', '.reply-btn', function(e) {
			e.preventDefault();
			$('.comment_info').show();
			var commentID = $(this).data('id');
			object = $(this).data('object');
			$('.delete-btn,.reply-btn').show();
			$(this).siblings('.delete-btn').hide();
			$(this).hide();
			$('.reply_text').val('');
			$('.reply_form').hide();
			$('#comment_reply_form_' + commentID).toggle();
			$('.submit-reply').show();
			$('.update-reply').hide();
			var url = $(this).parent().attr('action');
			$(document).on('click', '.submit-reply', function(e) {
				e.preventDefault();
				var commentID = $(this).data('id');
				var receiverID = $(this).data('receiver_id');
				var replyTextarea = $('#reply_text_' + commentID);
				submitReply(commentID, receiverID, replyTextarea, object,url);
			});
		});

   

	
   
});

