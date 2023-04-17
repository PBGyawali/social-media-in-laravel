		</div>
	</body>
</html>
<script>
    timeout();
    var columns = [];
    var order=['0','desc'];
    var method_type='';
    var from_date='';
    var to_date='';
    var tax_list;
    var brands;
    var product_list;
    var datatable='';

    var inputs = $(':input').filter(function() { // use * if not :input specific
    return Array.from(this.attributes)
        .some(a => a.nodeName.startsWith('data-parsley-'))
    })
    //similar result as above
    var attrCount = document.evaluate("count(//@*[starts-with(name(), 'data-parsley-')])", document)
    var attrcountnumber=attrCount.numberValue//this gives the count
    if(inputs.length>0){
        $('#form').parsley();
    }
    var url=$('#form').attr('action');

    listurl=url+'/list';
	var fetchurl=url+"/max";

    if(typeof CKEDITOR !== 'undefined')
        CKEDITOR.replace('body');

    function varname(start='',end=''){
        from_date=start
        to_date=end
    }
    function callback(response) {
        method_type = response;
    }

    function list(response) {
		product_list = response;
	}
    function calllist(response,secondlist=null) {
        tax_list = response;
        brands=	secondlist;
    }
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $( document ).ajaxSend(function() {
            $('.errormessage').html('');
            $('#action').attr('disabled', 'disabled');
        });
    $( document ).ajaxError(function( event, request, settings, thrownError ) {
        if (request.status == 422) {
            result('<div class="alert alert-danger text-center">'+request.responseJSON.message+'</div>');
                if(!$('.login').length>0){
                        $.each(request.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="'+i+'"]');
                        el.after($('<span class="text-danger errormessage">'+error[0]+'</span>'));
                    });
                }
        }
        else if ([401].includes(request.status)) {
            result('<div class="alert alert-danger text-center">'+request.responseJSON.message+ '</div>');
        }
        else if (request.status == 419) {
            result('<div class="alert alert-danger text-center">'+request.responseJSON.message+ ' Please relogin or refresh </div>');
        }
        else if(request.responseText!='')
        alert(request.responseText)
    });
    $( document ).ajaxComplete(function() {
        enableButton()
        $('.file_upload,.password').val('');
        $('progress').hide();
    })

    $("th").each(
    function ()
		{
            var classname=$(this).attr('class')
            var th =classname.split(' ')[0]
            var th2 =classname.split(' ')[1]
            if(th=='action'){
                columns.push({data: th,name:th,orderable:false,searchable:false})
            }
            else if(th2=="admininfo"){
                columns.push({
                    "className":th2,
                    "data":th,
                    "defaultContent": '',
                    'visible' :$('.'+th2).length > 0?true:false,
                    "render": function (data)
                    {
                        return  ($('.'+th2).length > 0)?data:'';
                    }
                })
            }
            else
            columns.push({data: th,name:th})
        }
);

if($('#table').length>0){


    var datatable= $('#table').DataTable({
			"processing":true,
			"serverSide":true,
			"order":order,
			"ajax" : {
                        url:url,
                        type:"POST",
                        dataType:'json',
                        data:{
                            from_date: function() { return from_date },
                            to_date: function() { return to_date }
                        }
			},
            columns:columns,
			"columnDefs":[
				{
					"targets":  [ 'action','admininfo'],
					"orderable":false,
				},
            ],
		});
}

    $('#add_button').click(function(){
        $('#form')[0].reset();
        var element=$(this).data('element')
        if(typeof CKEDITOR !== 'undefined')
        CKEDITOR.instances.body.setData('');
        $('#form').parsley().reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add "+element);
        $('#Modal').modal('show');
        $form=$('#Modal');
        $button= $form.find("button[type=submit]");
        $submit= $form.find("input[type=submit]");
        $button.html("Add");
        $submit.val("Add");
        $('.btn').attr('disabled', false);
        callback('/create');
        $('#publish,#anonymity').attr('checked',false);
      	$("#featured_image").prop('required', true);
        $('.errormessage,#span_item_details,#append_ticket,#form_message,#append_comment').html('');
        $('#product_tax').attr('required',false);
        $('#product_tax').hide();
        $('#brand_id').html('<option value="" >Select Category First</option>');
    });

    $(document).on('click', '.verify', function(){
        var id = $(this).data('id');
        callback('/'+id+'/update');
        $('#verifyModal').modal('show');
    });



      $(document).on('click', 'button.update', function(){
        var id = $(this).attr("id");
        if(!id)
            id = $(this).data('id');
        var element = $(this).data("prefix");
        $('#form')[0].reset();
        $('#form').parsley().reset();
        var finalurl=url+'/'+id+'/edit'
		$.ajax({
			url:finalurl,
			method:"POST",
			data:{unit_id:id},
			dataType:"json",
			success:function(data)
			{
               if ("error" in data && data.error!=''){
                        result(data.error);
                    return
                }
                callback('/'+id+'/update');
                if($('.tickets').length<=0){
                    $('#Modal').modal('show');
                }
                $form=$('#Modal');
                $button= $form.find("button[type=submit]");
                $submit= $form.find("input[type=submit]");
                $button.html("Edit");
                $submit.val("Edit");
                $('#span_tax_details,.object_details').html('');
                $('#product_tax').attr('required','required');
                $('#span_tax_details').html('');
                $('#product_tax').show();
                $('#user_password,#featured_image').attr('required', false);
                $('.btn').attr('disabled', false);
                $('#modal_title,#modal-title').html("<i class='fas fa-edit'></i> Edit " +element);
                if (typeof window[element+'_update']== "function") {
                    window[element+'_update'](data);
                }
                else
                update(data);
			}
		})
    });

    $(document).on('click', '.view', function(){
        var id = $(this).attr("id")||$(this).data('id');
        var finalurl=url+'/'+id+'/show'
        $.ajax({
            url:finalurl,
            method:"POST",
            dataType:'json',
            data:{},
            success:function(data){
                $('#detailsModal').modal('show');
                $('#object_details,#modal_item_details').html(data);
            }
        })
    });

    $(document).on('submit','#form,#second_form,.form', function(event){
    event.preventDefault();
    if(typeof CKEDITOR !== 'undefined')
        for ( instance in CKEDITOR.instances )
		    CKEDITOR.instances[instance].updateElement();
    var finalurl=url+method_type;
    var form_data = new FormData(this);
    $form=$(this);
    $button= $form.find("button[type=submit]:not('#send')");
    $submit= $form.find("input[type=submit]");    //$(document.activeElement);
    buttonvalue=$button.html();
    submitvalue=$submit.val();
    if ($form.hasClass('settings'))
    finalurl=$form.attr('action');
    //alert(finalurl)

    if($form.parsley().isValid())
    {
        $.ajax({
            url:finalurl,
            method:"POST",
            data:form_data,
            dataType:'json',
            contentType:false,
            processData:false,
            beforeSend:function()
            {
                disableButton($submit)
                disableButton($button)
            },
            complete:function()
            {
                $button.html(buttonvalue);
                $submit.val(submitvalue);
            },
            success:function(data)
            {
                if(typeof data=="string")
                {
                    result(data);
                    return
                }
                if ("error" in data && data.error!=''){
                    result(data.error);
                    return
                }
                if ("image" in data && data.image!=''){
                    $('#user_uploaded_image').html('<img src="'+data.image+'" class="img-thumbnail img-fluid rounded-circle" width="200" height="200" /><input type="hidden" name="hidden_user_image" value="'+data.image+'" />');
                }
                if ("redirect" in data && data.redirect!=''){
                    window.location.assign(data.redirect);
                }
                if ("update" in data && data.update!=''){
                    update(data.update)
                }
                if($('.login').length>0){
                    update(data)
                    return
                }
                if($('.no-close').length<=0){
                    $('#Modal,.modal').modal('hide');
                }
                if($('.reset,.no-reset').length<=0){
                    $form[0].reset()
                }
                if($('.timeago').length>0){
                    var time='.timeago'
                    if($('.chattimeago').length>0)
                    var time='.chattimeago'
						$(time).timeago('update', new Date());
					}
                $form.parsley().reset();
                if ("response" in data && data.response!=''){
                    result(data.response,datatable)
                }
                $('#span_tax_details,.item_details').html('');
                $('.file_upload,.password').val('');
            }
        })
    }
});

    $('.toggle').on( 'click', function (e)
        {		var column = datatable.column( $(this).attr('data-column') );
                column.visible( ! column.visible() );

            });


    $(document).on('click', 'button.reset', function(){
		var id = $(this).data('id');
		$clicked_btn = $(this);
        var url=$(this).data('url');
        var data={}
        data['id'] =id;
        disable(url,'',data,'reset the profile account password','POST',"Reset Password!",'red','');
	});

    $(document).on('click', 'button.delete', function(){
        var id = $(this).attr("id");
        if(!id)
            id = $(this).data('id');
         // alert(id);    // alert( $(this).attr('class'));            //return;
    var data={};
    var finalurl=url+'/'+id+'/delete'
    disable(finalurl,datatable,data,'delete the data','DELETE');
  });

  $(document).on('click', 'button.status', function(){
        var id = $(this).attr("id");
        if(!id)
           id = $(this).data('id');
		var status = $(this).data('status');
        var tableprefix=$(this).data('prefix');
        var finalurl=url+'/'+id+'/update'
        var data={}
        var column='status'
        if(!tableprefix)
            tableprefix =''
        else
            tableprefix +='_'
        var column_name=tableprefix+column;
      //  alert(column_name)
        //alert(status)
            data[column_name] =status;
		disable(finalurl,datatable,data,'change the status');
      });

        $(document).on('click', '#add_more', function(){
            count = $('.item_details').length;
            count = count + 1;
            add_row(count);
        });
        $(document).on('click', '.remove', function(){
            var row_no = $(this).attr("id");
            if(!row_no)
            row_no = $(this).data('id');
            $('#row'+row_no).hide();
            $('#item_details_row'+row_no).remove();
        });


    function  hide(){
        $('.error, .message').slideUp();
    }

    function clear(){
        $('#message,#alert_action,#form_message').html('')
    }
    function timeout(datatable='')
	{
		setTimeout(function(){hide();}, 7000);

		setTimeout(function(){clear();}, 10000);
		if(datatable)
		datatable.ajax.reload();
    }

    function result(data,dataTable=''){
        $('.errormessage').html('');
		$('#alert_action,#message,#form_message').fadeIn().html(data);
		timeout(dataTable);
    }





	function disable(url,datatable='',data,message="change the status",postmethod='POST',title='Confirmation please!',type='blue',btnClass='btn-blue'){
        $.confirm
        ({
            title: title,
            content: "This will "+ message+". Are you sure?",
			type: type,
            buttons:{
						Yes: {
                            btnClass: btnClass?btnClass:'btn-red',
							action: function() {
								$.ajax({
									url:url,
									method:postmethod,
									data:data,
                                    dataType:"JSON",
									success:function(response){
                                        if(typeof response=="string")
                                        {
                                            result(response);
                                            return
                                        }
                                        if ("error" in response && response.error!=''){
                                             result(response.error);
                                            return
                                        }
                                        else if ("response" in response)
                                            result(response.response,datatable);
                                        else if ("success" in response)
                                            result(response.success,datatable);
                                        else if ("delete" in response && response.delete!=='')
                                           destroy(response.delete)
									}
								});
							}
						},
					}
        });
    }
    function showAlert($content,$title='Error')
	{
			   $.alert({
						   title: $title,
						   content: $content,
						   buttons:
						   {
								   No: {
									   text:'OK',
									   btnClass: 'btn-blue',
								   },
								   Yes:{
									   isHidden: true,
								   }
						   }
					   });
	   }

    $('#filter').click(function(){
  		from_date = $('#from_date').val();
        to_date = $('#to_date').val();
        if(from_date==''){
            showAlert('Start date range needs to be selected','Filter date range error')
            return
          }
        if(to_date =='')
        to_date =current_date();
       varname(from_date, to_date);
        datatable.ajax.reload();
      });


  	$('#refresh').click(function(){
  		$('#from_date,#to_date').val('');
          varname();
          datatable.ajax.reload();
      });

    $('#report').click(function(){
  		var from_date = $('#from_date').val();
          var url=$(this).data('url')
        var to_date = $('#to_date').val();
        if(from_date==''){
            showAlert('Start date range needs to be selected','Report date range error');
            return
          }
        if(to_date =='')
        to_date =current_date();
        var table=$(this).data('table')
        reporturl=url+'/'+from_date+'/'+to_date+'/'+table
        window.open(reporturl);
      });

      $('#export').click(function(){
		  var url=$(this).data('url');
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val();
          if(from_date==''){
            showAlert('Start date range needs to be selected','Export date range error')
            return
          }
        if(to_date =='')
        to_date =current_date();
          exporturl=url+"/csv/from_date="+from_date+"&to_date="+to_date
        window.open(exporturl);
  	});

    function current_date(format='-'){
        var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            return yyyy+ format + mm + format + dd;
    }

    function printReport(response) {
	var mywindow = window.open('', '', 'height=400,width=600');
	mywindow.document.write('</head><body>');
	mywindow.document.write(response);
	mywindow.document.write('</body></html>');
	mywindow.document.close(); // necessary for IE >= 10
	mywindow.focus(); // necessary for IE >= 10
	mywindow.resizeTo(screen.width, screen.height);
        }// /success function

        function enableButton(value=false){
    $('.btn').attr('disabled', false);
    $('.btn').css({"filter": "","-webkit-filter": ""});
    enableText(value);
}
    function enableText(value=false,buttonvalue=''){
        if (!value)
        timeout();
        if (buttonvalue)
            $('#btn').html(buttonvalue);
        $('#hint').html('Login hint');
    }
    function disableButton(element='.btn'){
        $(element).css({"filter": "grayscale(100%)","-webkit-filter": "grayscale(100%)"});
        $(element).attr('disabled', 'disabled');
        $(element).html('Please wait...');
        $(element).val('Please wait...');

    }

    function User_update(data){
        $('#username').val(data.username);
        $('#email').val(data.email);
        $('#first_name').val(data.first_name);
        $('#last_name').val(data.last_name);
        $('#user_type').val(data.user_type);
    }

    function Ticket_update(data){
        detail=data.detail;
        $('#statusview').removeClass().text('('+detail.status+')');
        $('#messageview').text(detail.msg);
        $('#titleview').text(detail.title);
        $('#dateview').text(detail.created_at);
        $('#emailview').text(detail.email);
        $('#ticket_id').val(detail.id);
        $('.status').data('id',detail.id);
        $('#detailModal').modal('show');
        $('#allcomments').append(data.comments);
        $('#statusview').addClass(data.status);
    }

    function Post_update(data){
        var post_status=data.response.post_status;
        $('#publish,#anonymity').attr('checked',false);
        if (['1','active'].includes(post_status)) $('#publish').attr('checked',true);
        var anonymity_status=data.response.anonymous;
        if (['yes','active'].includes(anonymity_status))$('#anonymity').attr('checked',true);
        $('#title').val(data.response.title);
        $('#post_id').val(data.id);
        $('#user_id').val(data.response.user_id);
        $('#old_featured_image').val(data.response.image);
        CKEDITOR.instances.body.setData(data.response.body);
        $('#topic_id').val(data.topic);

    }

    function Topic_update(data){
        $('#topic_name').val(data.name);
    }
</script>
