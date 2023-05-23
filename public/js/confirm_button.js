$(document).ready(function(){
	
			$('.social_media_data').each(function (){
				media_button(this);								
			});

			$(document).on('change', '.social_media_data', function(e){	
				media_button(e.target)
			});			
			
			function media_button(thisObj) {
				var data = $(thisObj).val();
				var button_id = $(thisObj).data('id');
				if (!data) {
					$('#' + button_id).css({"filter": "grayscale(100%)", "-webkit-filter": "grayscale(100%)"});
				} else {
					$('#' + button_id).css({"filter": "", "-webkit-filter": ""});
				}				
			}
			
			$(document).on('change', '.social_media_data', function(e){	
				media_button(e.target);
			});
			$(document).on('click', '#facebook', function(){			
				socialMedia('facebook');
			});

			$(document).on('click', '#twitter', function(){
				socialMedia('twitter');
			});
			$(document).on('click', '#google-plus', function(){		
				socialMedia('google-plus','red');
			});

	function socialMedia($title,$color='blue'){
		$.confirm
		({
			title: $title.charAt(0).toUpperCase() + $title.slice(1),
			content:`<form id="confirm_form">
					<div class="form-input-group">
					<label >Please enter your ${$title} profile link.</label>
					<input type="text"  value="${$(`#${$title}_data`).val()}" 
						placeholder="Your link here" class="link form-control">
					</div>
					</form>` ,
			type: $color,
			//boxWidth: '35%',
			backgroundDismiss: false,
			icon: 'fab fa-'+$title,
			buttons: {
					Yes: {//also the name of the function
							text: 'Save',
							btnClass: 'btn-green',
							action: function(){
							var link= this.$content.find('.link').val();							
							$(`#${$title}_data`).val(link).change();	
						}
					},
					No: {
						text:'Cancel',
						btnClass: 'btn-blue',
				}
			},
		});
	};

});

