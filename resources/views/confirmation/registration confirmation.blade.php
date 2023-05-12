@include('config')
@include('login_head_section')

<meta http-equiv="refresh" content="30; url='<?= route('login')?>" />
	<title>Confirmation</title>
</head>
<body>
<div class="bigtext">
"Welcome to <?= $website_name; ?>"
</div>
<div class="image" >
<img src="<?= $website_logo; ?>"class="d-block mx-auto img-responsive " width="150" height= "150">
</div>
  <div class="header">
  <h2 class="text-center text-white mt-3">Confirmation</h2>
  </div>
  <form class="login-form text-center text-white" action="" >
		<p><h1>Success!!!</h1> <br>
			Thank you <?= $username?>. Your Account has been successfully registered.</p>
		<p>	We have sent an email to your account <b><?= $email;?></b> to help you confirm this registration.
		</p>
		<p>Please follow the link in your confirmation email to confirm this registration and you are good to go.</p>
		<br>
		<p>	Return to  <a href="<?= route('login')?>">Login</a></p>
	</form>


</body>
</html>
