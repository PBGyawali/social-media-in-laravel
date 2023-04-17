@include('config')
<?php
$website_name=$info->website_name;
$website_logo=$info->website_logo;
?>
@include('minimal_header')
@include('new_message')
<link rel="stylesheet" href="<?= CSS_URL?>outside_login.css">
<title><?= $website_name; ?></title>
</head>
<body>
@include('main_menu_top')
  <div class="container">
    <div class="header">
      <h2>RESET PASSWORD</h2>
  </div>
	<form class="login-form" action="<?= route('password.update') ?>" method="post">

    <h2 class="form-title">New password</h2>
        <div class="form-input-group">
        <label>New password</label>
			<input type="password" name="password" id="newpass"class="form-control" required data-parsley-minlength="5" data-parsley-trigger="on change">

		</div>
		<div class="form-input-group">
			<label>Confirm new password</label>
			<input type="password" name="password_confirmation" class="form-control" required data-parsley-equalto="#newpass" data-parsley-minlength="5" data-parsley-trigger="on change">
		</div>
		<div class="form-input-group">
        <?= csrf_field(); ?>
        <input type="hidden" name="email" value="<?= old('email', isset($request)?$request->email:'') ?>">
        <input type="hidden" name="token" value="<?= isset($request)?$request->route('token'):'' ?>">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
    </div>
    <script type="text/javascript" src="<?= JS_URL?>jquery.min.js"></script>

@include('footer_script')
