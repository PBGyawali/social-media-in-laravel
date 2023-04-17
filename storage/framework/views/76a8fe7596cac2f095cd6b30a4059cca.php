<div class="container"id="login_container">
    <div class="header">
      <h2>LOGIN</h2>
  </div>
  <span class="position-absolute text-center w-100"id="message" style="z-index:10;"><?php ///repeatmessage();?></span>
  <form method="post" class="user_form" action="<?= route('userlogin');?>#login" autocomplete="on">
  <div class="social">
        <h4>Connect with</h4>
        <ul>
          <li>
          <a href="<?php echo e(route('social.login', ['provider' => 'facebook'])); ?>" class="facebook"><span class="fab fa-facebook"></span></a>
          </li>
          <li>
          <a href="<?php echo e(route('social.login', ['provider' => 'twitter'])); ?>" class="twitter"><span class="fab fa-twitter"></span></a>
          </li>
          <li>
            <a href="<?php echo e(route('social.login', ['provider' => 'google'])); ?>" class="google-plus"><span class="fab fa-google-plus"></span></a>
          </li>
        </ul>
       </div>
    <div class="divider">
         <span>or</span>
       </div>
  	<div class="form-input-group">
  		<label>Username/Email</label>
      <i class="fa fa-user fa-md position-absolute loginicon"></i>
          <input type="text" name="login_email" id="login_username"class="form-control" value="<?=old('login_email')?old('login_email'):old('username')?>" required placeholder="Your Username or Email" >
          <?= $errors->hasAny('login_email','username')? '<span class="text-danger">'.$errors->first('login_email').'</span>':''?>
    </div>
  	<div class="form-input-group">
      <label>Password</label>
      <i class="fa fa-lock fa-md position-absolute loginicon"></i>
  		<input type="password" name="login_password" id="login_password" tabindex="1"class="form-control"  required  placeholder="Your Password" >
      <i class="fa fa-fw fa-eye field-icon toggle-password" ></i>

        </div>
        <div class="form-input-group">
      Forgot Your Password?<a class="reset_password_link" href="reset password.php"> RESET HERE. </a> Not a Member Yet?<a class="register_link"href="register.php"> SIGN UP HERE</a>
      </div>

  	<div class="form-input-group">
          <input type="hidden" name="website_name" value="<?= $info->website_name; ?>" >
          <input type="hidden" name="website_logo" value="<?= $website_logo; ?>" >
          <?= csrf_field(); ?>
          <button type="submit" name="submit"class="btn btn-primary">Login</button>
          <button type="submit" class="btn btn-secondary" name="login_guest" value="login_guest"id="login_guest">Login as a guest</button>
          <button type="button" class="btn btn-success"  id="hint">Show login hint</button>
              </div>
  </form>
  </div>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\includes/login_container.blade.php ENDPATH**/ ?>