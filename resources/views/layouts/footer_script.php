		</div>
	</body>
</html>
<script>
    timeout();
    let columns = [];
    let order=[];
    const defaultOrder=['0','desc'];
    const token=$('meta[name="csrf-token"]').attr('content');
    let methodUrl='';
    var from_date='';
    var to_date='';
    var tax_list;
    var brand_list;
    var product_list;
    var dataTable='';
    var autoRefresh=true;
    var hideTimeoutId;
    var clearTimeoutId;

    var inputs = $(':input').filter(function() { // use * if not :input specific
    return Array.from(this.attributes)
        .some(a => a.nodeName.startsWith('data-parsley-'))
    })
    //similar result as above
    var attrCount = document.evaluate("count(//@*[starts-with(name(), 'data-parsley-')])", document)
    var attrcountnumber=attrCount.numberValue//this gives the count
    if(inputs.length>0 && typeof parsley=='function'){
        $('#form').parsley();
    }
    var url=$('#form').attr('action');

    if(url){
        url=modifyUrl(url)
    }

    listurl=url+'/list';
	var fetchurl=url+"/max";

    if(typeof CKEDITOR !== 'undefined')
        CKEDITOR.replace('body');

    function defineDateRange(start='',end=''){
        from_date=start
        to_date=end
    }

    function callback(...args) {
        if (args.length === 0||args.length === 1) {
            methodUrl = args;
        } else {
            methodUrl="/" + args.join("/");
        }
    }


    function modifyUrl(currentUrl, ...replaceArgs) {
        if (!currentUrl.startsWith("http://localhost/")) {
            currentUrl = currentUrl.replace("http", "https");
        }

        for (let i = 0; i < replaceArgs.length; i += 2) {
            const replaceableText = replaceArgs[i];
            const replaceableValue = replaceArgs[i + 1];
            currentUrl = currentUrl.replace(encodeURIComponent(replaceableText), encodeURIComponent(replaceableValue))
                                    .replace(replaceableText, encodeURIComponent(replaceableValue));
        }

        return currentUrl;
    }


    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $( document ).ajaxSend(function(event, jqxhr, settings) {
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
            showMessage(request.responseJSON.message);
        }
        else if (request.status == 419) {
            showMessage(request.responseJSON.message+ ' Please relogin or refresh');
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
            if(classname){
                    var th =classname.split(' ')[0]
                    var th2 =classname.split(' ')[1]
                    var th3 =classname.split(' ')[2]

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
                    });
                }
                else{
                    columns.push({data: th,name:th})
                }
                if(th2=='order'){
                        var lastIndex = columns.length - 1;
                        order.push([lastIndex,th3||'desc']);
                };
            }
        }
);

        draw_table()
        function draw_table(){    //launch dataTables only if table exist in page
            if($('#table').length>0){
                dataTable= $('#table').DataTable({
                        "processing":true,
                        "serverSide":true,
                        "responsive": true,
                        "order":order.length != 0 ?order:defaultOrder,
                        "ajax" : {
                                    url:url,
                                    type:"GET",
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
        }


    $('#add_button').click(function(e){
        let element=$(this).data('element');
        if(typeof CKEDITOR !== 'undefined')
        CKEDITOR.instances.body.setData('');
        let modal=$(this).data('target') ||'#Modal';
        $form=$(modal).find('form');
        $form[0].reset();
        if(typeof 'parsley'=='function')
        $form.parsley().reset();
        $title=$(modal).find('.modal-title');
        $title.html("<i class='fa fa-plus'></i> Add "+element);
        //do not know if the form has input/submit or button/submit so doing both here
        $button= $form.find("button[type=submit]");
        $submit= $form.find("input[type=submit]");
        //changing the submit button values from edit, please wait etc to add
        $button.html('<i class="fa fa-paper-plane"></i>'+ " Store "+element).attr('disabled', false);
        $submit.val('<i class="fa fa-paper-plane"></i>'+  " Store "+element).attr('disabled', false);
        $('.btn').attr('disabled', false);
        //adding extra string to current base url
        callback('/create');
        $('#publish,#anonymity').attr('checked',false);
      	$("#featured_image").prop('required', true);
        $('.errormessage,#span_item_details,#append_ticket,#form_message,#append_comment').html('');
        $('#product_tax').attr('required',false);
        $('#product_tax').hide();
        $('#brand_id').html('<option value="" >Select Category First</option>');
        var clickedElement = $(e.target);
        if (clickedElement.is('a') || clickedElement.parents('a').length > 0) {
            const linkElement = clickedElement.is('a') ? clickedElement : clickedElement.parents('a').eq(0);
            if (linkElement.attr('href') !== 'javascript:;') {
                //if the link tag does not have javascript value
                //then it takes to another page so cancel any further actions
                return;
            }
        }
        $(modal).modal('show');
    });

        $(document).on('click', '.verify', function(){
            let id = $(this).attr("id")||$(this).data('id')
            callback(id,'update');
            $('#verifyModal').modal('show');
        });



    function createDisplayName(str) {
        return str.replace(/_/g, " ")
                    .replace("id", "name")
                    .replace("from", "start")
                    .replace("to", "end")
                    .split(" ")
                    .map(word => word.charAt(0)
                    .toUpperCase() + word.slice(1))
                    .join(" ");
        }

      $(document).on('click', 'button.update', function(){
        let id = $(this).attr("id")||$(this).data('id')
        var element = $(this).data("prefix");
        let modal=$(this).data('target') ||'#Modal';
        $form=$(modal).find('form');
        $form[0].reset();
        if(typeof 'parsley'=='function')
        $form.parsley().reset();
        var finalurl=url+'/'+id+'/edit'
        finalurl = modifyUrl(finalurl);
        ajaxCall(finalurl).then(function(result) {
            callback(id,'update');
            
            $form=$(modal).find('form');
            $button= $form.find("button[type=submit]");
            $submit= $form.find("input[type=submit]");
            $button.html("Edit " +element);
            $submit.val("Edit "+element);
            $('#span_tax_details,.object_details').html('');
            $('#product_tax').attr('required','required');
            $('#product_tax').show();
            $('#user_password,#featured_image').attr('required', false);
            $('.btn').attr('disabled', false);
            $title=$(modal).find('.modal-title');
            $title.html("<i class='fas fa-edit'></i> Edit " +element);
            if (typeof window[element+'_update']== "function") {
                window[element+'_update'](result);
            }
            else if(typeof 'update'== "function")
            update(result);
            else
            easy_update(result);
            if($('.ticketsd').length<=0){
                    $(modal).modal('show');
            }
        })
    });

    $(document).on('click', '.view', function(){
        var id = $(this).attr("id")||$(this).data('id');
        var finalurl=url+'/'+id+'/show'
        finalurl = modifyUrl(finalurl);
        ajaxCall(finalurl).then(function(result) {
            $('#detailsModal').modal('show');
            $('#object_details,#modal_item_details').html(result);
        })
    });

    $(document).on('submit','#form,#second_form,.form', function(event){
        event.preventDefault();
        if(typeof CKEDITOR !== 'undefined')
            for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
        let finalurl=url+methodUrl;
        const form_data = new FormData(this);
        $form=$(this);
        $button= $form.find("button[type=submit]:not('#send')");
        buttonvalue=$button.html();
        if ($form.hasClass('settings'))
            finalurl=$form.attr('action');
        finalurl = modifyUrl(finalurl);
        if($form.parsley().isValid())
        {
            ajaxCall(finalurl,form_data).then(function(result) {
                    if($('.login').length>0){
                        update(result)
                        return
                    }
                    if($('.no-close').length<=0){
                        $('#Modal,.modal').modal('hide');
                    }
                    if($('.reset,.no-reset').length<=0){
                        $form[0].reset()
                    }
                    $form.parsley().reset();
                    $('#span_tax_details,.item_details').html('');
                    $('.file_upload,.password').val('');
                    $button.html(buttonvalue);
                    $submit.val(submitvalue);
            }).catch(function(error) {
                $button.html(buttonvalue);
                $submit.val(submitvalue);
            });

        }
    });

    $('.toggle').on( 'click', function (e)
    {		var column = dataTable.column( $(this).attr('data-column') );
                column.visible( ! column.visible() );

    });


    $(document).on('click', 'button.reset', function(){
		let id = $(this).attr("id")||$(this).data('id')
		$clicked_btn = $(this);
        var url=$(this).data('url');
        var data={}
        data['id'] =id;
        disable(url,data,'reset the profile account password','POST',"Reset Password!",'red','');
	});

    $(document).on('click', 'button.delete', function(){
        let id = $(this).attr("id")||$(this).data('id')
    var data={};
    let baseUrl=$(this).data('url')||url
    var finalurl=baseUrl+'/'+id+'/delete'
    disable(finalurl,data,'delete the data','DELETE');
  });

  $(document).on('click', 'button.status', function(){
        let id = $(this).attr("id")||$(this).data('id')
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
            data[column_name] =status;
		disable(finalurl,data,'change the status');
      });

    $(document).on('click', '#add_more', function(){
        count = $('.item_details').length;
        count = count + 1;
        add_row(count);
    });

    $(document).on('click', '.remove', function(){
        var row_no =$(this).attr("id")||$(this).data('id');
        $('#row'+row_no).hide();
        $('#item_details_row'+row_no).remove();
    });


    function  hide(){
        $('.error, .message,#alert').slideUp();
    }

    function clear(){
        $('#message,#alert_action,#form_message').html('')
    }


    function clearPreviousTime(){
        clearTimeout(hideTimeoutId);
        clearTimeout(clearTimeoutId);
    }

    function timeout()
	{
        clearPreviousTime();

        hideTimeoutId = setTimeout(function(){hide();}, 7000);
        clearTimeoutId = setTimeout(function(){clear();}, 10000);

        if(dataTable && autoRefresh) {
            dataTable.ajax.reload();
        }
    }

    function result(data){
        $('.errormessage').html('');
		$('#alert_action,#message,#form_message').fadeIn().html(data);
		timeout();
    }


    function showMessage(message,type='danger')
	{
        let response=
        `<div class="alert alert-${type} alert-dismissible fade show" id="alert">
            <button type="button" class="close" onclick="hide()">&times;</button>
                            ${message}
        </div>`
        result(response)
	}


    function disable(finalUrl,data,message="change the status",postmethod='POST',title='Confirmation please!',type='blue',btnClass='btn-blue'){
        $.confirm
        ({
            title: title,
            content: "This will "+ message+". Are you sure?",
            type: type,
            buttons:{
                        Yes: {
                            btnClass: btnClass??'btn-red',
                            action: function() {
                                ajaxCall(finalUrl,data,postmethod);
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



        function ajaxCall(sendUrl,sendData=[],postmethod='POST') {
            let ajaxUrl=modifyUrl(sendUrl);
            return new Promise(function(resolve, reject) {
                let contentType="application/x-www-form-urlencoded; charset=UTF-8";
                let processData=true;
                if (sendData.constructor === FormData) {
                    contentType=false;
                    processData=false;
                }
                $.ajax({
                    url: ajaxUrl,
                    method:postmethod,
                    data:sendData,
                    dataType:"JSON",
                    contentType:contentType,
                    processData:processData,
                    success: function(response) {
                        if(typeof response=="object"){
                            let responseKeys=['error','response','success']
                            $.each(responseKeys, function(key, value){
                                if (value in response && response[value]){
                                    if($('<div>').html(response[value]).find('div').length) {
                                        result(response[value]);
                                    } else {
                                        let classValue=(value=='response')?'success':value;
                                        showMessage(response[value],classValue);
                                    }
                                }
                            });
                            if ("image" in response && response.image){
                                $('.profile_image').attr('src',response.image);
                            }
                            if ("delete" in response && response.delete){
                                $(`#newticketcomment_${response.delete}`).remove();
                            }
                            if ("redirect" in response && response.redirect!=''){
                                window.location.assign(response.redirect);
                            }
                            if ("update" in response && response.update!=''){
                                update(response.update)
                            }
                        }
                        resolve(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        reject(errorThrown);
                    }
                });
            });
        }

    // $(window).resize(function(){
    //     if(dataTable)
    //     dataTable.destroy();
    //     draw_table()
    // })


      $('#refresh').click(function(){
  		$('#from_date,#to_date').val('');
          defineDateRange();
         //dataTable.ajax.reload();
         dataTable.destroy();
         draw_table()
  	});

        $('#export,#report,#filter').click(function(){
  		var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(!from_date){
            showAlert('Start date range needs to be selected')
            return
        }
        if(!to_date)
        to_date =current_date();
        var currentUrl=$(this).data('url')
        if(currentUrl){
                reportUrl=modifyUrl(currentUrl,':from_date', from_date,':to_date',to_date)
                window.open(reportUrl);
        }
        else{
            defineDateRange(from_date, to_date);
            dataTable.ajax.reload();
        }
  	});


    function current_date(format = 'yyyy-mm-dd') {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');//January is 0!
        const dd = String(today.getDate()).padStart(2, '0');

        return format.replace('yyyy',yyyy)
                     .replace('mm',mm)
                     .replace('dd',dd)
                     .replace('yy',yyyy)
    }

    function enableButton(value=false){
        $('.btn,button').attr('disabled', false).css({"filter": "","-webkit-filter": ""});

    }

    function disableButton(element='button[type="submit"].btn'){
        $(element).css({"filter": "grayscale(100%)","-webkit-filter": "grayscale(100%)"});
        $(element).attr('disabled', 'disabled');
        $(element).html('Please wait...');
        $(element).val('Please wait...');

    }

    function Ticket_update(detail){
        $('#messageview').text(detail.msg);        
        $('#dateview').text(detail.created_at);
        $('#emailview').text(detail.email);
        $('#ticket_id').val(detail.id);
        $('.status').data('id',detail.id);
        $('#allcomments').append(detail.comments);        
        $('.modal-title').html(`<span id="titleview">${detail.title}</span>        
        <span id="statusview" class="${detail.status_class}">(${detail.status})</span>`)
    }
            
        function easy_update(data) {
            $.each(data, function(key, value) {
                let $element = $(`[name="${key}"]`);                
                if ($element.is(":checkbox")) {                    
                  $element.prop("checked", $element.val() == value||['1','active','yes'].includes(value));
                } else if ($element.is(":radio")) {
                    $element.filter(`[value="${value}"]`).prop("checked", true);
                 }
                else if ($element.is('textarea') && typeof CKEDITOR !== 'undefined' 
                        && CKEDITOR.instances[key]) {
                        CKEDITOR.instances[key].setData(value);                    
                }
                else {
                    $element.val(value);
                }
            });
        }








</script>
