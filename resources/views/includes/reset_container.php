<div class="container" id="reset_password_container">
  <div class="header">
  	<h2>Reset password</h2>
  </div>
	<form action="<?= route('password.email');?>#reset_password"  method="post">
		<!-- form validation messages -->

		<div class="form-input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" class="form-control" value="<?= old('email')?>">
  	</div><br>
		<div class="form-input-group">
    <input type="hidden" name="website_name" value="<?= $info->website_name; ?>" >


    <?= csrf_field(); ?>
			<button type="submit" name="reset-password" class="btn btn-primary">Submit</button>
		</div>
		<br>
      Go to <a class="login_link"href="login.php">Sign in</a> or return to  <a class="homepage_link"href="index">Homepage</a>

	</form>
</div>
