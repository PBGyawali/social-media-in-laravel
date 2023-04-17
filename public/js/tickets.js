    function add_row(count_comment){
		var html = `
		<div class="row mt-2 item_details" id="item_details_row`+count_comment+`">
			<label class="col-md-4">&nbsp;</label>
			<div class="col-md-6">
				<input type="text" name="ticket_comments[]" placeholder="Enter comments here"class="form-control ticket_comment"  data-parsley-pattern="/^[a-zA-Z0-9]+$/"  data-parsley-trigger="keyup" />
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-danger btn-sm remove" data-id="`+count_comment+`">-</button>
			</div>
		</div>
		`;
		$('#append_comment').append(html);
	}

$('#comment_form').on('submit', function(event)
{
	event.preventDefault();
	if($('#comment_form').parsley().isValid())
	{
        var url=$('#comment_form').attr('action')
		var ticketid=$('#ticket_id').val();
		var msg=$('#ticketcomments').val();
		var r='<div id="newticketcomment_'+1+'">'+
		'<div>'+
			'<i class="fas fa-comment fa-2x"></i>'+
		'</div>'+
			'<span class="ticketcomments">'+msg+'  '+'<i class="fas fa-clock text-warning"></i>'+
			'<p><span class="ticketcommentdate">'+'</span></p></div>';

		$.ajax({
			url:url,
			method:"POST",
			data:{msg:msg, ticket_id:ticketid},
			dataType:"JSON",
			beforeSend:function()
			{
				$('#allcomments').append(r);
			},
				success:function(data)
			{
                $('#newticketcomment_'+1).remove();
                $('.commenticon').remove();
				$('#allcomments').append(data.response);
			},
			complete:function()
			{
				$('#ticketcomments').val('');
				$('#comment_form').parsley().reset();
			},

		})
	}
});



