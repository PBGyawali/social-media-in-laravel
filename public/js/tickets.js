$('#comment_form').on('submit', function(event)
{
	event.preventDefault();
	if($('#comment_form').parsley().isValid())
	{
        var url=$('#comment_form').attr('action')
		var ticketid=$('#ticket_id').val();
		var msg=$('#ticketcomments').val();
		$.ajax({
			url:url,
			method:"POST",
			data:{msg:msg, ticket_id:ticketid},
			dataType:"JSON",
			beforeSend:function()
			{
				var html = `
					<div id="newticketcomment_0">
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
			},
			success:function(data)
			{
                $('#newticketcomment_0').remove();
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



