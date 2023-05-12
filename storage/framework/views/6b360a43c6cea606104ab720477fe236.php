<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_sidebar',['no_sidebar'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="main-wrapper">
       
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Inbox</h4>
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
                                                <button type="button" class="btn btn-light border border-info dropdown-toggle" data-toggle="dropdown">Select <i class="fa fa-angle-down "></i></button>
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
                                                    <a class="dropdown-item" href="#">Reply</a>
                                                    <a class="dropdown-item" href="#">Forward</a>
                                                    <a class="dropdown-item mark_archive" href="#">Archive</a>
                                                    <div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item mark_read" href="#">Mark As Read</a>
                                                    <a class="dropdown-item mark_unread" href="#">Mark As Unread</a>
													<div class="dropdown-divider"></div> 
                                                    <a class="dropdown-item mark_delete" href="#">Delete</a>
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
                                            <input type="text" placeholder="Search Messages" class="form-control search-message">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-4 col-4 top-action-right">
                                        <div class="text-right">
                                            <span class="text-muted d-none d-md-inline-block">Showing 10 of 112 </span>
                                            <button type="button" title="Refresh" data-toggle="tooltip" class="btn btn-white d-none d-md-inline-block"><i class="fa fa-refresh"></i></button>
                                            <div class="btn-group">
                                                <a class="btn btn-white"><i class="fa fa-angle-left"></i></a>
                                                <a class="btn btn-white"><i class="fa fa-angle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email-content">
								<div class="table-responsive">
									<table class="table table-inbox table-hover">
										<thead>
											<tr>
												<th colspan="6">
													<input type="checkbox" id="check_all">
												</th>
											</tr>
										</thead>
										<tbody>
                                            <?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                         
                                                <tr class="<?php echo e(['','unread font-weight-bold'][array_rand([1,2])]); ?> clickable-row" href="<?php echo e(route('support.show',['id'=>$email->getKey()])); ?>">
                                                    <td>
                                                        <input type="checkbox" class="checkmail ">
                                                    </td>
                                                    <td><span class="mail-important"><i class="fa-star <?php echo e(['far','fas text-warning'][array_rand([1,2])]); ?>"></i></span></td>
                                                    <td class="name"><?php echo e([$email->full_name,'me,'.($names[array_rand($names)]).'('.rand(1, 10).')'][array_rand([1,2])]); ?></td>
                                                    <td class="subject"><?php echo e($email->subject); ?></td>
                                                    <td><?php echo ['','<i class="fa fa-paperclip"></i>'][array_rand([1,2])]; ?></td>
                                                    <td class="mail-date"><?php echo e($email->created_at); ?></td>                                                  
                                                </tr>                                       
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	                                                                                        																
										</tbody>
									</table>

                                    <div class="table table-inbox table-hover">										
											<div class="row border border-light pl-3 py-2">
												<div class="col">
													<input type="checkbox" id="check_all">												
											    </div>
                                            </div>										
										
                                            <?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="text-dark link-dark" href="<?php echo e(route('support.show',['id'=>$email->getKey()])); ?>">
                                            <div class="row pl-3 border border-light py-2 <?php echo e(['','unread font-weight-bold'][array_rand([1,2])]); ?> clickable-row" href="<?php echo e(route('support.show',['id'=>$email->getKey()])); ?>">
                                            <div class="col-1">
                                                <input type="checkbox" class="checkmail ">
                                            </div>
                                            <div class="col-1">
                                                <span class="mail-important"><i class="fa-star <?php echo e(['far','fas text-warning'][array_rand([1,2])]); ?>"></i></span>
                                            </div>
                                            
                                            <div class="col-3 name">
                                                <?php echo e([$email->full_name,'me,'.($names[array_rand($names)]).'('.rand(1, 10).')'][array_rand([1,2])]); ?>

                                            </div>
                                            <div class="col-5 subject">
                                                <?php echo e($email->subject); ?>

                                            </div>
                                            <div class="col-1">

                                                <?php echo ['','<i class="fa fa-paperclip"></i>'][array_rand([1,2])]; ?>

                                            </div>
                                            <div class="col-1 mail-date">
                                                <?php echo e($email->created_at); ?>


                                            </div>
                                            </div>    
                                        </a>                                   
                                                                                  
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	                                                                                        																
										
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>            
                    </div>
                </div>
            </div>
        </div>

<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>

    // Check all email
	$(document).on('click', '#check_all', function() {
		$('.checkmail').click();
	});

    $(document).on('click', '.check_all', function() {
		$('.checkmail').prop('checked',true);
        $('.checkmail').closest('tr,.row').addClass('bg-warning');       
	});

    $(document).on('click', '.uncheck_all', function() {
		$('.checkmail').prop('checked',false);
        $('.checkmail').closest('tr,.row').removeClass('bg-warning');       
	});

    $(document).on('click', '.check_read', function() {
        $('.checkmail').prop('checked',false).closest('tr,.row').removeClass('bg-warning');
		$('.clickable-row').not('.unread')
        .find(':checkbox').prop('checked',true)
        .closest('tr,.row').addClass('bg-warning');       
	});

    $(document).on('click', '.check_unread', function() {
        $('.checkmail').prop('checked',false).closest('tr,.row').removeClass('bg-warning');
        $('.unread').find(':checkbox').prop('checked', true).closest('tr,.row').addClass('bg-warning');
    });

    $(document).on('click', '.mark_read', function() {
        $('.checkmail:checked').closest('tr,.row').removeClass('unread font-weight-bold');    
	});

    $(document).on('click', '.mark_unread', function() {
        $('.checkmail:checked').closest('tr,.row').addClass('unread font-weight-bold'); 
    });

    $(document).on('click', '.mark_delete', function() {
        $('.checkmail:checked').closest('tr,.row').fadeOut('slow');       
	});

    $(document).on('click', '.mark_archive', function() {
        $('.checkmail:checked').closest('tr,.row').fadeOut('slow');       
	});

	if($('.checkmail').length > 0) {
		$('.checkmail').each(function() {
			$(this).on('click', function() {
                if($(this).prop('checked'))				
				$(this).closest('tr,.row').addClass('bg-warning');
                else
                $(this).closest('tr,.row').removeClass('bg-warning');				
			});
		});
	}
	
	// Mail important
		$(document).on('click', '.mail-important', function() {
		$(this).find('i.fa-star').toggleClass('fas far text-warning');
	});
</script><?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/inbox.blade.php ENDPATH**/ ?>