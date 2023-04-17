<form method="post" id="form" class="form profile no-reset" enctype="multipart/form-data" action="<?= route('user.profile')?>">
    <span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>
    <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">User Name <span class="text-danger">*</span></label>
            <div class="col-md-8">
                <input type="text" name="username" id="username" class="form-control"   data-parsley-pattern="/^[a-zA-Z\s]+$/"  data-parsley-trigger="keyup" value="<?= $username; ?>" />
            </div>
        </div>
      </div>
      <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">User Email <span class="text-danger">*</span></label>
            <div class="col-md-8">
                <input type="email" name="email" id="email" class="form-control"  data-parsley-type="email"  data-parsley-trigger="keyup" value="<?= $email; ?>" />
            </div>
        </div>
      </div>
      <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">First name <span class="text-danger"></span></label>
            <div class="col-md-8">
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $firstname ?>" />
            </div>
        </div>
      </div>
      <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">Last name <span class="text-danger"></span></label>
            <div class="col-md-8">
                <input type="text" name="last_name" id="last_name" class="form-control"   value="<?= $lastname ?>" />
            </div>
        </div>
      </div>
      <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">Sex <span class="text-danger"></span></label>
            <div class="col-md-8 ">
                <input type="radio" name="sex" id="sex" value="male"  <?=  ($sex=='male')?'checked':''; ?> required/> Male
                <input type="radio" name="sex" id="sex" value="female" <?= ($sex=='female')?'checked':''; ?> required/> Female
                <input type="radio" name="sex" id="sex" value="other"  <?= ($sex=='other')?'checked':''; ?> required/> Other
                <input type="radio" name="sex" id="sex" value="not mentioned"  <?= ($sex=='not mentioned')?'checked':''; ?> required/> Secret
            </div>
            </div>
      </div>
      <div class="form-group text-center mb-0">
      <input type="hidden" name="facebook" class="social_media_data" data-id="facebook" id="facebook_data"value="<?= $facebook?>">
        <input type="hidden"  name="twitter" class="social_media_data" data-id="twitter" id="twitter_data"value="<?= $twitter?>">
        <input type="hidden" name="googleplus" class="social_media_data" data-id="google-plus" id="google-plus_data"value="<?= $googleplus?>">
          <input type="hidden" name="user_id" id="user_id"value="<?= $user['id']; ?>" />
          <button type="submit"  id="submit_button" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
          <button  type="button" id="go_back" onclick="history.go(-1);" class="btn btn-primary"><i class="fas fa-reply"></i> Go back</button>
      </div>
</form>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/profile_form.blade.php ENDPATH**/ ?>