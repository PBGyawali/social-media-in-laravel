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
    var dataTable='';
    var autoRefresh=true;
    var hideTimeoutId;
    var clearTimeoutId;

    var pageInputs = $(':input').filter(function() { // use * if not :input specific
    return Array.from(this.attributes)
        .some(a => a.nodeName.startsWith('data-parsley-'))
    })
    //similar result as above
    var attrCount = document.evaluate("count(//@*[starts-with(name(), 'data-parsley-')])", document)
    var attrcountnumber=attrCount.numberValue//this gives the count
    if(pageInputs.length>0 && typeof parsley=='function'){
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

   


    function modifyUrl(currentUrl, ...replaceArgs) {
        if (!currentUrl) {
            return currentUrl;
        }
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

    function changeUrl(...args) {
        if (args.length === 0||args.length === 1) {
            methodUrl = args;
        } 
        else {         
            methodUrl = args.filter(Boolean).join("/");
            if (methodUrl.startsWith("/")) {
                methodUrl = methodUrl.substring(1);
            }
            methodUrl = "/" + methodUrl;
        }
    }


    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $( document ).ajaxSend(function(event, jqxhr, settings) {
            $('.errormessage').html('');
            $('#action').attr('disabled', 'disabled');
            //alert(settings.url); // logs the URL of the AJAX request
        });
    $( document ).ajaxError(function( event, request, settings, thrownError ) {
        if (request.status == 422) {
                showError(request.responseJSON.message);            
                if(!$('.login').length>0){
                        $.each(request.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="'+i+'"]');
                        el.after($('<span class="text-danger errormessage">'+error[0]+'</span>'));
                    });
                }
        }
        else if (request.status == 419) {
            showMessage(`${request.responseJSON.message} Please relogin or refresh`);
        }
        else if ([401,404,403,400].includes(request.status)) {
            showError(request.responseJSON.message); 
        }       
        else if(request.responseText!=''){
            alert(request.responseText)
        }
       
    });
    $( document ).ajaxComplete(function() {
        enableButton()
        $('progress').hide();
        $('input[type="file"],input[type="password"]').val('');
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
        //changing the submit button values from edit, please wait etc to add
        $button.html('<i class="fa fa-paper-plane"></i>'+ " Store "+element).attr('disabled', false);
        //adding extra string to current base url
        changeUrl('/create');
        $('#publish,#anonymity').attr('checked',false);
      	$("#featured_image").prop('required', true);
        $('.errormessage,#span_item_details,#append_ticket,#form_message,#append_comment').html('');
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
            changeUrl(id,'update');
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

        function getCurrentUrl() {
            return window.location.origin+window.location.pathname;
        }

      $(document).on('click', 'button.update', function(){
        let id = $(this).attr("id")||$(this).data('id')
        var element = $(this).data("prefix");
        let modal=$(this).data('target') ||'#Modal';
        $form=$(modal).find('form');
        $form[0].reset();
        if(typeof 'parsley'=='function')
        $form.parsley().reset();
        changeUrl(id,'edit');
        var finalUrl=url+methodUrl
        finalUrl = modifyUrl(finalUrl);
        ajaxCall(finalUrl).then(function(result) {
            changeUrl(id,'update');
            $form=$(modal).find('form');
            $button= $form.find("button[type=submit]");
            $button.html(`Edit ${element}`);
            $('#user_password,#featured_image').attr('required', false);
            $title=$(modal).find('.modal-title');
            $title.html(`<i class='fas fa-edit'></i> Edit ${element}`);           
            if (typeof window[element+'_update']== "function") {
                window[element+'_update'](result);
            }
            else if(typeof 'update'== "function")
            update(result);
            else
            easy_update(result);        
            $(modal).modal('show');
            
        })
    });

    $(document).on('click', '.view', function(){
        var id = $(this).attr("id")||$(this).data('id');
        var finalUrl=url+'/'+id+'/show'
        finalUrl = modifyUrl(finalUrl);
        ajaxCall(finalUrl).then(function(result) {
            $('#detailsModal').modal('show');
            $('#object_details,#modal_item_details').html(result);
        })
    });

    $(document).on('submit','#form,#second_form,.form', function(event){
        event.preventDefault();
        if(typeof CKEDITOR !== 'undefined')
            for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
        let finalUrl=url+methodUrl;
        $form=$(this);
        $button= $form.find("button[type=submit]:not('#send')");
        $form.append($("<input>").attr({name:"_token",type:"hidden",value:token}));
        const form_data = new FormData(this);
        buttonvalue=$button.html();
        if ($form.hasClass('settings')||$form.hasClass('chat'))
            finalUrl=$form.attr('action');
        finalUrl = modifyUrl(finalUrl);
        if($form.parsley().isValid())
        {
            ajaxCall(finalUrl,form_data).then(function(result) {
                    if($('.login').length>0){
                        update(result)
                        return
                    }
                    if($('.no-close').length<=0){
                        $('#Modal,.modal').modal('hide');
                    }
                    if($('.no-reset').length<=0){
                       $form[0].reset()
                    }
                    if(typeof 'parsley'=='function')
                    $form.parsley().reset();
                    $button.html(buttonvalue);

            }).catch(function(error) {
                $button.html(buttonvalue);
            });

        }
    });

    $('.toggle').on( 'click', function (e)
    {		var column = dataTable.column( $(this).attr('data-column') );
                column.visible( ! column.visible() );

    });    

    $(document).on('click', 'button.reset', function(){
        const $clickedButton = $(this);
        const { baseUrl, message, title, data } = getButtonData($clickedButton);
        const finalUrl = baseUrl;
        confirmAction(finalUrl, data, message, 'POST', title, 'red', null);
	});

    $(document).on('click', 'button.delete', function(){
        const $clickedButton = $(this);
        const { baseUrl, message, title, data } = getButtonData($clickedButton);
        changeUrl(data.id, 'delete'); 
        const finalUrl = baseUrl + methodUrl;
        //confirmAction(finalUrl,data,message,'DELETE',title,'red',null)
    confirmAction(finalUrl,data,message,'DELETE',title,'red',null).then(function(result) {
            changeUrl(); }).catch(function(error) {
                changeUrl(); 
            });
  });

    function getButtonData($button) {
        const id = $button.attr('id') || $button.data('id');
        const baseUrl = $button.data('url') || url || getCurrentUrl();
        const element = $button.data('element') || $button.data('prefix') || 'data';
        const message = ($button.attr('title') || `delete the ${element}`).toLowerCase();
        const title = ($button.attr('title') || `Delete ${element}`).replace(element.toLowerCase(),'') + '!';
        var data = {id: id};

        $.each($button.data(), function(key, value) {
            data[key] = value;
        });
        return { baseUrl: baseUrl, message: message,title: title,data: data};
    }

  $(document).on('click', 'button.status', function(){
        $clickedButton = $(this);
         // Get the ID attribute, or use the data ID if it's not present
        const id = $clickedButton.attr('id') || $clickedButton.data('id');
        // Get the current status and table prefix from data attributes
        const status = $clickedButton.data('status');
        const tablePrefix = $clickedButton.data('prefix')||'';
        let baseUrl=$clickedButton.data('url')||url||getCurrentUrl()
        var data={}
        const column = 'status';
        columnWithPrefix = column;
        //add the table prefix and column variable to make the column name
        if (tablePrefix) {
            columnWithPrefix = `${tablePrefix}_${column}`;
        }
        data[columnWithPrefix] =status;
        const statusTask={'inactive':'deactivate','active':'activate'}
        changeUrl(id,'update');
        //final url to use to send the request
        var finalUrl=baseUrl+methodUrl
		confirmAction(finalUrl,data,`${statusTask[status]} the ${tablePrefix}`);
      });

    $(document).on('click', '#add_more', function(){
        count = $('.item_details').length;
        count = count + 1;
        add_row(count);
    });

    $(document).on('click', '.remove', function(){
        var rowNumber =$(this).attr("id")||$(this).data('id');
        $('#row'+rowNumber).hide();
        $('#item_details_row'+rowNumber).remove();
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

    function showError(message)
	{
        showMessage(message,'danger')
	}

    function showSuccess(message)
	{
        showMessage(message,'success')
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


    function confirmAction(finalUrl,data,message="change the status",postmethod='POST',title='Confirmation please!',type='blue',btnClass=null){
        //create a deferred object
        var defer = $.Deferred();
        $.confirm
        ({
            title: title,
            content: "This will "+ message+". Are you sure?",
            type: type,
            backgroundDismiss: false,
            buttons:{
                        Yes: {
                            btnClass: `btn-${btnClass??type??'red'}`,
                            action: function() {
                               ajaxCall(finalUrl, data, postmethod)
                                .then(function(value) {
                                    defer.resolve(value); // Resolve the deferred object with the value
                                })
                                .catch(function(error) {
                                    defer.reject(error); // Reject the deferred object with the error
                                });
                            }
                        },
                    }
        });
        return defer.promise();
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
                     // Custom XMLHttpRequest
                     xhr: function () {
                        var myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                            // For handling the progress of the upload
                            myXhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    $('progress').attr({
                                        value: e.loaded,
                                        max: e.total,
                                    }).show();
                                }
                            }, false);
                        }
                        return myXhr;
                    },
                    success: function(response) {
                        if(typeof response=="object"){
                            processResponse(response)
                        }
                        resolve(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 0 && textStatus === 'error') {
                            // Lack of internet connection error
                            reject('No internet connection');                            
                        }
                        else
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
                     .replace('yy',yyyy)
                     .replace('y',yyyy)
                     .replace('mm',mm)
                     .replace('m',mm)
                     .replace('dd',dd)
                     .replace('d',dd)
                     
    }

    function enableButton(value=false){
        $('.btn:not(.social_media_buttons)').attr('disabled', false).css({"filter": "", "-webkit-filter": ""});

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
            if(typeof data !='object')
            return
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
                else if (!$element.is(":file") ){
                    $element.val(value);
                }
            });
        }

        function processResponse(response) {
            if(typeof response=="object"){       
                const responseKeys=['error','response','success']
                const classKeys=['danger','success','success']
                    $.each(responseKeys, function(key, value){
                        if (value in response && response[value]){
                            if($('<div>').html(response[value]).find('div').length) {
                                result(response[value]);
                            } else {
                                let classValue=classKeys[key];
                                showMessage(response[value],classValue,value=='error'?null:true);
                            }
                        }
                    });
                    if ("image" in response && response.image){
                        $('.profile_image').attr('src',response.image);
                        $('#fancybox').attr('href',response.image);
                    }
                    if("button" in response && response.button){
                        $('#delete_div').html(response.button);
                    }                 
                    if ("delete" in response && response.delete){
                        $(`#newticketcomment_${response.delete},#chatmessage_${response.delete}`).remove();
                        $(`.removable_div_${response.delete}`).remove();
                    }
                    if ("delete_all" in response && response.delete_all){
                        $(`${response.delete_all}${response.delete_id}`).remove();
                    }
                    if ("redirect" in response && response.redirect){
                        window.location.assign(response.redirect);
                    }
                    if ("update" in response && response.update){                    
                        if(typeof update== "function"){
                            update(response.update,response);
                        }                        
                        else{
                            easy_update(response.update);
                        }                        
                    }
                    if ("replace" in response && response.replace){
                        replace(response.replace,response.replace_id)
                    }
                    if ("scroll" in response && response.scroll){
                        $("#messages_area,#user-chat-content"+response.id).animate({ scrollTop: $(document).height() }, 1000);
                    }
                    if ("typing" in response){
                        $('#typing_on').html(response.typing)                    
                    }
            }  	
        }



        function replace(data,divId){
            $(`.removable_div_${divId}`).replaceWith(data);
        }


</script>
