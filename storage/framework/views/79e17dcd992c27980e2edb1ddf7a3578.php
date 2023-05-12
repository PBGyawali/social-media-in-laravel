<div class="container-fluid mt-0 top-0 sticky-top bg-dark" >
	    <div class="row">
	        <div class="col-12 col-sm-6 col-md-7 sidebar-brand d-flex align-items-start ">
	            <!-- toggler -->
	            <a data-toggle="collapse" href="" data-target=".collapse" role="button" onclick="$('#rightsidebar').toggleClass('col-10')">
					<h3 class="my-0 text-white text-center navbar-brand"><?= $info->website_name?> <?= ucwords(auth()->user()->user_type??'test');?> Panel</h3>
	            </a>
            </div>
            <div class="col-12 col-sm-6  col-md-5 text-center">
                <div class="d-flex flex-column   justify-content-center" >
                    <nav class="navbar navbar-light navbar-expand topbar static-top py-0">
                            <ul class="nav navbar-nav  ml-auto">
                            <?php echo $__env->make('alert_notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!--alert div ends here-->
                            <?php echo $__env->make('message_notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make('dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </ul>
                    </nav>
                </div>
	        </div>
        </div>
</div>

	<div class="container-fluid " >
	    <div class="row vh-100 ">
			
	        <div class="col-2 collapse show bg-dark">
				<?php if(empty($no_sidebar)): ?>

	            <ul class="nav flex-column flex flex-fill sidebar  bg-gradient-primary " id="sidebar" >
					<li class="nav-item text-center">
                        <span id="user_uploaded_image_medium" class="d-none d-lg-inline-block">
                            <img src="<?= auth()->user()->profile_image; ?>" class="rounded-circle mb-0 img-fluid profile_image" width="100" height="100"/>
                        </span>
                    </li>
	            	<li class="nav-item">
	                    <a class="nav-link  <?= $dashboard_active; ?>" href="<?= route('admin.dashboard')?>"><span class=""><i class="fas fa-tachometer-alt"></i> <span class="d-none d-md-inline-block">Dashboard</span></span></a>
	                </li>
	            	<?php
	            	if(auth()->user()->is_admin()):?>
	            	<li class="nav-item">
	                    <a class="nav-link <?= $user_active; ?>" href="<?= route('user')?>"><span class=""><i class="fas fa-users"></i> <span class="d-none d-md-inline-block">Users</span></span></a>
					</li>
                    <?php endif 	?>
					<li class="nav-item">
					    <a class="nav-link dropdown-btn <?= $manage_article; ?>">
							<span title="Click to view and manage your post" class="dropdown-toggle"> 
								<span class="d-none d-md-inline-block">Article</span>  
							</span> 
						</a>						
						
						<div class="dropdown-container dropdown-menu-right animated zoomIn text-center">
                            <a class="nav-link <?= $posts_active; ?>" href="<?= route('post')?>">
								<span class=""><i class="far fa-newspaper"></i> 
									<span class="d-none d-md-inline-block">manage posts</span>
								</span>
							</a>
                            <a class=" <?= $topics_active; ?>" href="<?= route('topic')?>">
								<span class=" "><i class="fas fa-key"></i> 
									<span class="d-none d-md-inline-block">manage Topics</span>
								</span>
							</a>
  						</div>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link <?= $tickets_active; ?>" href="<?= route('ticket')?>">
							<span class=" "><i class="fas fa-ticket-alt"></i> 
								<span class="d-none d-md-inline-block">Tickets</span>
							</span>
						</a>
	                </li>
					<li class="nav-item">
	                    <a class="nav-link <?= $support_active; ?>" href="<?= route('support')?>"><span class=" "><i class="fas fa-envelope"></i> <span class="d-none d-md-inline-block">Inbox</span></span></a>
	                </li>
					<li class="nav-item">
	                    <a class="nav-link inactive_class" href="<?= route('home')?>" title="View the website as a normal user"><span class=""><i class="fas fa-user"></i> <span class="d-none d-md-inline-block">User Panel</span></span></a>
					</li>
	            </ul>
				<?php else: ?>
			
				<ul class="text-white" >
					<li class="nav-item">
						<a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link inactive_class"><i class="fa fa-home back-icon"></i> <span>Back to Home</span></a>
					</li>
					<li class="menu-title"><a href="<?php echo e(route('support.create')); ?>" class="btn btn-primary btn-block">Compose</a></li>
					<li class="pt-3 nav-item">
						<a href="<?php echo e(route('support')); ?>" class="nav-link <?php echo e($support_active); ?>">Inbox <span class="mail-count">(<?php echo e($total_inbox??''); ?>)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link inactive_class" href="#">Starred</a>
					</li>
					<li class="nav-item">
						<a class="nav-link inactive_class" href="#">Sent Mail</a>
					</li>
					<li>
						<a class="nav-link inactive_class" href="#">Trash</a>
					</li>
					<li>
						<a class="nav-link inactive_class" href="#">Draft <span class="mail-count">(<?php echo e($total_draft??8); ?>)</span></a>
					</li>
					<li> <a class="nav-link inactive_class" href="#">Label <i class="fa fa-plus text-right"></i></a></li>
					<li>
						<a class="nav-link inactive_class" href="#"><i class="fa fa-circle text-success mail-label"></i> Work</a>
					</li>
					<li>
						<a class="nav-link inactive_class" href="#"><i class="fa fa-circle text-danger mail-label"></i> Office</a>
					</li>
					<li>
						<a class="nav-link inactive_class" href="#"><i class="fa fa-circle text-warning mail-label"></i> Personal</a>
					</li>
				</ul>
				
				<?php endif; ?>
				
			</div>
	<script src="<?= JS_URL.'confirmdefaults.js'?>"></script>
    <script src="<?= JS_URL.'confirm.js'?>"></script>
    <script src="<?= JS_URL.'dropdown_button.js'?>"></script>			
			<div id="rightsidebar" class="col col-10  ">
			
		

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\admin\includes/admin_sidebar.blade.php ENDPATH**/ ?>