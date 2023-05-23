@include('config')
@include('admin_header')
@include('admin_sidebar',['no_sidebar'=>true])
@include('message')


    <div class="main-wrapper">
       
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">{{ucwords($page??'Inbox')}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="email-header">
                                <div class="row">
                                    <div class="col-sm-10 col-md-8 col-8 top-action-left">
                                        <div class="float-left">
                                            <div class="btn-group dropdown-action">
                                                <input type="checkbox" class="btn border border-info"id="check_all"><span class=" btn btn-light border border-info dropdown-toggle" data-toggle="dropdown">Select</span>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item check_all" href="#">All</a>
                                                    <a class="dropdown-item uncheck_all" href="#">None</a>
													<div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item check_read" href="#">Read</a>
                                                    <a class="dropdown-item check_unread" href="#">Unread</a>
                                                </div>
                                            </div>
                                            <div class="btn-group dropdown-action">
                                                <button type="button" class="btn btn-white dropdown-toggle border border-info" data-toggle="dropdown">Actions <i class="fa fa-angle-down "></i></button>
                                                <div class="dropdown-menu">                                                 
                                                    <a class="dropdown-item" href="#">Forward</a>
                                                    <a class="dropdown-item mark_archive" href="#">Archive</a>
                                                    <div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item mark_read" href="#">Mark As Read</a>
                                                    <a class="dropdown-item mark_unread" href="#">Mark As Unread</a>
													<div class="dropdown-divider"></div>                                                    
                                                    @if($page=='trash')
                                                        <a class="dropdown-item force_delete" href="#">Delete permanently</a>
                                                        <a class="dropdown-item restore" href="#">Restore</a>
                                                    @else
                                                        <a class="dropdown-item soft_delete" href="#">Delete</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="btn-group dropdown-action">
                                                <button type="button" class="btn btn-white dropdown-toggle border border-info" data-toggle="dropdown"><i class="fa fa-folder"></i> <i class="fa fa-angle-down"></i></button>
                                                <div role="menu" class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Social</a>
                                                    <a class="dropdown-item" href="#">Forums</a>
                                                    <a class="dropdown-item" href="#">Updates</a>
													<div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item" href="#">Spam</a>
                                                    <a class="dropdown-item" href="#">Trash</a>
													<div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item" href="#">New</a>
                                                </div>
                                            </div>
                                            <div class="btn-group dropdown-action">
                                                <button type="button" data-toggle="dropdown" class="btn btn-white dropdown-toggle border border-info"><i class="fa fa-tags"></i> <i class="fa fa-angle-down"></i></button>
                                                <div role="menu" class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Work</a>
                                                    <a class="dropdown-item" href="#">Family</a>
                                                    <a class="dropdown-item" href="#">Social</a>
													<div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item" href="#">Primary</a>
                                                    <a class="dropdown-item" href="#">Promotions</a>
                                                    <a class="dropdown-item" href="#">Forums</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="float-left d-none d-sm-block">
                                            <form method="get">
                                                <input type="text" name="search" placeholder="Search Messages" class="form-control search-message">
                                            </form>                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-4 col-4 top-action-right">
                                        <div class="text-right">
                                            <span class="text-muted d-none d-md-inline-block email-data">Showing {{(($emails->currentPage() - 1) * $emails->perPage() + 1)}} to {{min($emails->total(),$emails->currentPage()*$emails->perPage())}} of {{$emails->total()}}</span>
                                            <button type="button" title="Refresh" data-toggle="tooltip" class="btn btn-white d-none d-md-inline-block"><i class="fa fa-refresh"></i></button>
                                            <div class="btn-group">
                                                {{ $emails->links('vendor.pagination.simple-default') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email_content" id="email_content">
								@include('emails-table')
                            </div>
                        </div>
                    </div>
                </div>            
                    </div>
                </div>
            </div>
        </div>
   
@include('footer_script')

<script>
   var messageIds = [];
    var currentUrl = getCurrentUrl();
    var updateUrl= currentUrl.replace('inbox', 'inbox/update').replace('trash', 'inbox/update');
    var deleteUrl=currentUrl.replace('inbox', 'inbox/delete').replace('trash', 'inbox/delete');

    $(document).on('click', '.uncheck_all,.check_all,#check_all', function() {
        let checkingAction = $(this).hasClass('check_all') || $(this).prop('checked') || false;
        let classAction=checkingAction?'add':'remove';
		$('.checkmail').prop('checked',checkingAction).change();      
	});

    $(document).on('click', '.check_read, .check_unread', function() {
        const isRead = $(this).hasClass('check_read'); 
        $('.checkmail').prop('checked', false).change()
        const $targetRows = isRead ? $('.clickable-row').not('.unread') : $('.clickable-row.unread');
        $targetRows.find(':checkbox').prop('checked', true).change()
    });


    $(document).on('change', '.checkmail', function(event,sentClass,sentAction) {
        let ClassName=sentClass??'bg-secondary text-white';    
            let classAction='removeClass';            
            if($(this).prop('checked')){
                var id=$(this).data('id');                
                messageIds.push(id);
                classAction=sentAction??'addClass';
            }             
			$(this).closest('tr,.row')[`${classAction}`](ClassName);                     
    });
  
    $(document).on('click', '.mark_unread,.mark_read', function(e) {
        e.preventDefault();
        messageIds = [];
        $('.checkmail').trigger('change');
        const isRead = $(this).hasClass('mark_read');     
        let action=isRead?'yes':'no';
        let classAction=isRead?'remove':'add'; 
        let data= { message_ids: messageIds,read_by_user:action}
        if (messageIds.length > 0) {
            ajaxCall(updateUrl,data,'patch').then(function(result){               
                $('.checkmail:checked').trigger('change',['unread font-weight-bold',`${classAction}Class`])
                update_count(result)
            })        
        }  
    });

        function update_count(result){
            $.each(result, function(key, value) {                   
                if(value||typeof value=='number')                    
                $(`.${key}`).html(value)
            }); 
        }
    

    // Mail important
    $(document).on('click', '.mail-important', function(e) {
        e.preventDefault();
        let element=$(this);
        messageIds = [element.data('id')];
        let action=element.find('i.fa-star').hasClass('fas text-warning')?'inactive':'active';
        let data= { message_ids: messageIds,'important':action }
            if (messageIds.length > 0) {
                ajaxCall(updateUrl,data,'patch').then(function(result){
                    element.find('i.fa-star').toggleClass('fas far text-warning'); 
                })        
            }
    });

    $(document).on('click', '.soft_delete,.restore,.force_delete', function() {
        let element=$(this);
        messageIds = [];
        $('.checkmail').trigger('change');
        let data= { message_ids: messageIds }            
        const classList = ['force_delete', 'restore', 'soft_delete'];
        classList.forEach(className => {
            if (element.hasClass(className)) {
                data[className] = true;
            }
        });
        if (messageIds.length > 0) {
            ajaxCall(deleteUrl,data,'delete').then(function(result){
                $('.checkmail:checked').trigger('change',['slow',`fadeOut`])
                update_count(result);    
            })        
        }             
	});

    $(document).on('click', '.mark_archive', function() {
        $('.checkmail:checked').closest('tr,.row').fadeOut('slow');       
	});
       

        $('.search-message').keyup(function() {
            let search = $(this).val();
            let data = {search: search};
            ajaxCall('',data,'get').then(function(result){
                $('.email_content').html(result.email_content)
            })
        });

</script>