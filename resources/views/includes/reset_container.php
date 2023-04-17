<div class="container" id="reset_password_container">
  <div class="header">
  	<h2>Reset password</h2>
  </div>
	<form action="<?= route('password.email');?>#reset_password"  method="post">
		<!-- form validation messages -->
	<div class="form-input-group">
  	  <label class="d-inline-block">Email</label> 
  	  <input type="email" name="email" class="form-control" value="<?= old('email')?>" >
        <?=  $errors->has('reset_email')? '<span class="text-danger">'.$errors->first('reset_email').'</span>':''?>
    </div>
	<br>
	  <div class="g-recaptcha" data-theme="dark" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
	<div class="form-input-group">
    <input type="hidden" name="website_name" value="<?= $info->website_name; ?>" >
	<script src="https://www.recaptcha.net/recaptcha/api.js?render=6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></script>
    		<?= csrf_field(); ?>
		<button type="submit" name="reset-password" class="btn btn-primary mt-3">Submit</button>
	</div>
		<br>
      Go to <a class="login_link"href="login.php">Sign in</a> or return to  <a class="homepage_link"href="index">Homepage</a>

	</form>
</div>
