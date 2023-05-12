<?php
$topics =$topics??array();
$side='user.';
?>
</head>
<body class="p-0 ">
<div class="container-fluid bg-dark d-inline px-0 " style="z-index:1049;">
<?php if(in_array($page,array('dashboard','home','welcome'))):  ?>
<div class="row d-none d-sm-block">
	<img src="<?= LOGO_URL.'new_banner.jpg'?>" alt="Banner" class="img-fluid">
</div >
<?php  endif ?>
	    <div class="row sticky-top py-0 px-1">
		<div class="col-12 col-sm-3 col-md-4 bg-dark pr-0 ">
			<div class="row">
				<div class="col-3 col-sm-2 text-right pr-1 mr-0">
					<img src="<?= $info->website_logo; ?>"class="img-fluid mt-0 pt-0" width="45" height= "45">
				</div>
				<div class="col-9 col-sm-10 text-left pl-0 ml-0 my-auto ">
					<span class="navbar-brand mb-0 pb-0 text-white d-inline h2 float-left"><?= $website_name??''?></span>
					<button class="d-block d-sm-none  navbar-toggler  d-inline btn btn-sm btn-dark p-0 mt-2 mr-3 float-right" data-toggle="collapse" data-target=".topbar"><i class="fas fa-align-justify"></i> </button>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-9 col-md-8  pl-0 pr-0">
			<div class="d-flex flex-column" >
                <nav class="  navbar navbar-expand-sm navbar-light bg-dark  topbar  pl-4 static-top">
				<ul class="nav  flex pl- 3  ">
				<?php if(auth()->user()||session()->has('guest')):  ?>
					<?php if(auth()->user()):  ?>
					<li ><a href="<?= route('dashboard') ?>"><span class="btn btn-primary btn-sm mb-1 mr-2 my-2 <?= $dashboard_active??'' ?> "> <i class="d-none d-sm-inline-block fas fa-tachometer-alt"></i><span> Dashboard</span></span></a></li>
					<li ><a  href="<?= route('home') ?>"><span class="btn btn-primary btn-sm mr-2 my-2 <?= $home_active??'' ?> "><i class="d-none d-sm-inline-block fas fa-home"></i> Home</span></a></li>
					<li class="dropdown mx-1" role="presentation">
						<div class="dropdown"><a class="dropdown" data-toggle="dropdown" aria-expanded="false" ><span class="btn btn-primary btn-sm my-2 <?= $manage_article??'' ?>"> <i class="fa fa-caret-down"></i><span> Article</span></span></a>
							<div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
								role="menu">
								<a class="d-flex align-items-center dropdown-item" href="<?=route('article.create')?>">
									<div class="mr-3">
										<div class="text-dark ">Create Article</div>
									</div>
								</a>
								<a class="d-flex align-items-center dropdown-item" href="<?=route('article')?>">
									<div class="mr-3">
										<div class="text-dark ">Manage Article</div>
									</div>
								</a>
							</div>
							</div>
					</li>
					<?php else:  ?>
					<li ><a  href="<?=route('welcome')?>"><span class="btn btn-primary btn-sm mr-2 my-2 <?= $welcome_active??'' ?> "><i class="d-none d-sm-inline-block fas fa-home"></i><span> Home</span></span></a></li>
					<?php endif  ?>
				<?php endif ?>
				<li ><a  href="<?=route('about')?> "><span class="btn btn-primary btn-sm mr-2 mb-1 my-2 <?= $about_active??'' ?>"><i class="d-none d-sm-inline-block far fa-smile-beam"></i><span> About</span><span></a></li>
        		<li ><a class="contactus"  data-toggle="modal" data-receiver_type="user" data-id="<?=  auth()->id();?>" data-target="#messageModal"> <span class="btn btn-primary btn-sm mr-2 my-2 "><i class="d-none d-sm-inline-block fas fa-envelope"></i> Contact</span></a></li>
				<li class="dropdown mr-2 " role="presentation">
					<div class="dropdown"><a class="dropdown" data-toggle="dropdown" aria-expanded="false" ><span class="btn btn-primary btn-sm my-2 <?= $topics_active??'' ?>"><i class="fa fa-caret-down"></i> Topics</span></a>
						<div class="dropdown-menu dropdown-menu-right dropdown-list animated--grow-in"
							role="menu">
							<?php foreach ($topics as $topic): ?>
								<a class="d-flex align-items-center dropdown-item" href="<?= route('topic.show',$topic->id) ?>">
								<div class="mr-3">
									<div class="text-dark "><?= $topic->name; ?></div>
								</div>
								<div>
								</div>
								</a>
							<?php endforeach ?>
					</div>
				</li>
					<?php if(auth()->user()) :?>
                        <?php include(COMPONENTS.'alert_notification.blade.php')?>
                        <!--alert div ends here-->
                        <?php include(COMPONENTS.'message_notification.blade.php')?>
						<!--message div ends here-->
                        <?php include(COMPONENTS.'dropdown.blade.php')?>
			        <?php else:?>
					<li>
                        <form action="<?= route('logout')?>" method="post" class="logout_form">
                            <?= csrf_field(); ?>
							<button class="btn btn-primary btn-sm mr-1 my-2" type="submit" >&nbsp;<?= (session()->has('guest'))?"Logout as Guest":"Login as User"?></button>
						</form>
					</li>
					<li ><a  href="<?= route('register')?>"><span class="btn btn-primary btn-sm mx-1 my-2 "><i class="fas fa-graduate"></i> Register</span></a></li>
			<?php endif?>
	        </div>
	    </div>
	</div></div>

<div>




