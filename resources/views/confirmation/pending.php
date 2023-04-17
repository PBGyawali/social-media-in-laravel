	<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
		include_once(INCLUDES.'login_head_section.php');
	?>
	<title>Pending Confirmation</title>
	<script type="text/javascript" src="<?= JS_URL?>history.js"></script>
	</head>
	<body>
		<div class="bigtext">
			Welcome to "<?= $info->website_name; ?>"
		</div>
		<div class="image" >
			<img src="<?= $info->website_logo; ?>"class="d-block mx-auto img-responsive " width="150" height= "150">
		</div>
		<div class="container container-fluid">
			<div class="header">
				<h2 class="text-center text-white mt-3">Confirmation</h2>
			</div>
			<form class="login-form text-center text-white" action="" >
					<h4>
						<p>	We sent an email to  your account <b><?= $email ?></b> to help you recover your account.</p>
					</h4>
					<h3> <strong><u>Next step:</u> </strong> </h3>
					<h4>
						<p>Please login into your email account and click on the link sent to your email to reset your password</p>
					</h4>
					<p> Go to
						<a href="<?= route('login')?>">Sign in</a>
						or return to
						<a href="<?= route('heading')?>">Homepage</a>
					</p>
			</form>
		<div>
	</body>
</html>
