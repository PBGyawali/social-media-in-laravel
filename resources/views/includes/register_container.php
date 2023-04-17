<div class="container" id="register_container">
  <div class="header">
	  <h2>Register</h2>
  </div>

  <span class="text-center position-absolute w-100 message"id="error_msg" style="z-index:978"></span>
  <form name="myForm" class="user_form" id="register_form" method="post" data-url="<?= route('user.register');?>"action="<?= route('user.register');?>#register" >

  <div class="form-input-group">
    <label class="d-inline-block">Username</label><span class="d-inline-block position-relative " style="z-index:978"> </span>
  	  <input type="text" name="registered_username" id="registered_username" value="<?= old('registered_username')?>"class="form-control datacheck" data-object="Username"  required data-parsley-minlength="5" data-parsley-trigger="on change">
        <?= $errors->has('registered_username')? '<span class="text-danger">'.$errors->first('registered_username').'</span>':''?>

    </div>
  	<div class="form-input-group">
  	  <label class="d-inline-block">Email</label> <span class="d-inline-block position-relative "></span>
  	  <input type="email" name="registered_email" value="<?= old('registered_email')?>"id="registered_email" class="form-control datacheck" data-object="Email"  required data-parsley-type="email" data-parsley-trigger="on change">
        <?=  $errors->has('registered_email')? '<span class="text-danger">'.$errors->first('registered_email').'</span>':''?>

    </div>
	  <div class="form-input-group">
		<label>Confirm Email</label>
		<span></span>
  	  <input type="email" name="registered_email_confirmation" value="<?= old('registered_email_confirmation')?>" id="register_confirmemail" class="form-control"required data-parsley-equalto="#registered_email" data-parsley-trigger="on change">
        <?=  $errors->has('registered_email_confirmation')? '<span class="text-danger">'.$errors->first('registered_email_confirmation').'</span>':''?>
    </div>
  	<div class="form-input-group">
    <label>Password</label>
    <span id="strength_message"></span>
  	  <input type="password" name="password" id="register_password_1" class="form-control" required data-parsley-minlength="5">
        <?=  $errors->has('password')? '<span class="text-danger">'.$errors->first('password').'</span>':''?>
  </div>
  	<div class="form-input-group">
		<label>Confirm password</label>
		<span></span>
  	  <input type="password" name="password_confirmation"id="register_password_2" class="form-control"  required data-parsley-minlength="5" data-parsley-equalto="#register_password_1"data-parsley-trigger="on change">
        <?=  $errors->has('password_confirmation')? '<span class="text-danger">'.$errors->first('password_confirmation').'</span>':''?></div>
      <div>

      <p>
      By clicking on Register you automatically agree to our <a class="conditions_link formlink"href="conditions.php">TERMS & CONDITIONS</a>
</p>
  	</div>
  	<div class="form-input-group">
    <input type="hidden" name="website_name" value="<?= $info->website_name; ?>" >
    <input type="hidden" name="website_logo" value="<?= $info->website_logo; ?>" >
    <?= csrf_field(); ?>
		<button type="submit" class="btn btn-primary" id= "reg_btn" name="reg_user">Register</button>
        <button type="reset" class="btn btn-info" >Reset</button>
      </div>
      <br>
  	<p>
      Already a member? <a class="login_link" href="login">Sign in</a> or return to  <a class="homepage_link"href="/">Homepage</a>
  	</p>
  </form>
  </div>
