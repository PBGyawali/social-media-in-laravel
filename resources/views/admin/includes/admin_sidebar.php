<?php
$website_name=session('website_name')??SITE_NAME;
$username=auth()->user()->username??'newuser';
$user_id=auth()->id();
$profileimage=auth()->user()->profile_image??'no_image';
$dashboard_active=$user_active=$tickets_active=$posts_active =$topics_active=
$manage_article='inactive_class';
$alertcount=$alertcount??0;
$messagecount=$messagecount??0;
${$page."_active"} = 'active_class';
if($page== 'posts'|| $page =='topics')$manage_article='active_class' ;
$side='';
?>
<div class="container-fluid mt-0 top-0 sticky-top bg-dark" >
	    <div class="row">
	        <div class="col-12 col-sm-6 col-md-7 sidebar-brand d-flex align-items-start ">
	            <!-- toggler -->
	            <a data-toggle="collapse" href="" data-target=".collapse" role="button">
					<h3 class="my-0 text-white text-center navbar-brand"><?= $website_name?> <?= ucwords(auth()->user()->user_type??'test');?> Panel</h3>
	            </a>
            </div>
            <div class="col-12 col-sm-6  col-md-5 text-center">
                <div class="d-flex flex-column   justify-content-center" >
                    <nav class="navbar navbar-light navbar-expand topbar static-top py-0">
                            <ul class="nav navbar-nav  ml-auto">
                            <?php include(COMPONENTS.'alert_notification.blade.php')?>
                            <!--alert div ends here-->
                            <?php include(COMPONENTS.'message_notification.blade.php')?>
                            <?php include(COMPONENTS.'dropdown.blade.php')?>
                            </ul>
                    </nav>
                </div>
	        </div>
        </div>
</div>
	<div class="container-fluid " >
	    <div class="row vh-100 ">
	        <div class="col-2 collapse show bg-dark ">
	            <ul class="nav flex-column flex flex-fill sidebar  bg-gradient-primary " id="sidebar" >
					<li class="nav-item text-center">
                        <span id="user_uploaded_image_medium">
                            <img src="<?= $profileimage; ?>" class="rounded-circle mb-0 img-fluid" width="100" height="100"/>
                        </span>
                    </li>
	            	<li class="nav-ite">
	                    <a class="nav-link  <?= $dashboard_active; ?>" href="<?= route('admin.dashboard')?>"><span class=""><i class="fas fa-tachometer-alt"></i> <span class="d-none d-md-inline-block">Dashboard</span></span></a>
	                </li>
	            	<?php
	            	if(auth()->user()->is_admin()):?>
	            	<li class="nav-item">
	                    <a class="nav-link <?= $user_active; ?>" href="<?= route('user')?>"><span class=""><i class="fas fa-users"></i> <span class="d-none d-md-inline-block">Manage Users</span></span></a>
					</li>
                    <?php endif 	?>
					<li class="nav-item">
					    <a class="nav-link dropdown-btn <?= $manage_article; ?>"><span title="Click to view and manage your post" class="dropdown-toggle"> <span class="d-none d-md-inline-block">Manage Article</span>  </span> </a>
						<div class="dropdown-container animated zoomIn">
                            <a class="nav-link <?= $posts_active; ?>" href="<?= route('post')?>"><span class=""><i class="far fa-newspaper"></i> <span class="d-none d-md-inline-block">Manage</span> posts</span></a>
                            <a class="nav-link <?= $topics_active; ?>" href="<?= route('topic')?>"><span class=" "><i class="fas fa-key"></i> <span class="d-none d-md-inline-block">Manage</span> Topics</span></a>
  						</div>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link <?= $tickets_active; ?>" href="<?= route('ticket')?>"><span class=" "><i class="fas fa-ticket-alt"></i> <span class="d-none d-md-inline-block">Tickets</span></span></a>
	                </li>
					<li class="nav-item">
	                    <a class="nav-link inactive_class" href="<?= route('home')?>" title="View the website as a normal user"><span class=""><i class="fas fa-user"></i> <span class="d-none d-md-inline-block">User Panel</span></span></a>
					</li>
	            </ul>
			</div>
			<div class="col-10 ">
    <script src="<?= JS_URL.'confirmdefaults.js'?>"></script>
    <script src="<?= JS_URL.'confirm.js'?>"></script>
    <script src="<?= JS_URL.'dropdown_button.js'?>"></script>
