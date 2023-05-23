$('#comment_form').on('submit', function(event)
{
	event.preventDefault();
	if($('#comment_form').parsley().isValid())
	{
        var finalurl=$('#comment_form').attr('action')
		var ticketid=$('#ticket_id').val();
		var msg=$('#ticketcomments').val();
		let sendData={msg:msg, ticket_id:ticketid};
		chatMessage(msg)
		ajaxCall(finalurl,sendData).then(function(data){
			$('.fake_div').remove();
			$('.commenticon').remove();
			$('#allcomments').append(data.comments);
		}).then(function(){
			$('#ticketcomments').val('');
			$('#comment_form').parsley().reset();
		})
		
	}
});

function chatMessage(msg){
	var html = `
				<div class="fake_div" id="newticketcomment_0">
					<div>
						<i class="fas fa-comment fa-2x"></i>
					</div>
					<span class="ticketcomments">${msg} <i class="fas fa-clock text-warning"></i>
					<p><span class="ticketcommentdate">
					${current_date()}
					</span>
					</p>
				</div>
				`;
				$('#allcomments').append(html);
  }