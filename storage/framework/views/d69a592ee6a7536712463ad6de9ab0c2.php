<div class="card-body pr-0">

    <div class="col-md-12">
        <form method="post" id="form" class="password"action="<?=route('user.password')?>">
            <div class="form-group">
                  <div class="row">
                    <label class="col-xs-12 col-sm-3 text-left pl-0 pr-1 ">Current Password <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-9 pl-0">
                        <input type="password" name="current_password" id="old_password" class="form-control"    data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
                    </div>
                </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <label class="col-xs-12 col-sm-3 text-left pl-0 pr-1 ">New Password <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-9 pl-0">
                        <input type="password" name="password" id="new_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
                    </div>
                </div>
              </div>
              <div class="form-group">
                  <div class="row">
                    <label class="col-xs-12 col-sm-3 text-left pl-0 pr-1 ">Confirm Password <span class="text-danger">*</span></label>
                    <div class="col-xs-12 col-sm-9 pl-0 ">
                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control"  required data-parsley-equalto="#new_password" data-parsley-trigger="on change" />
                    </div>
                </div>
              </div>
              <br />
              <div class="form-group text-center">
                    <input type="hidden" id="changer_id" value="<?= $user->id ?>" />
                  <button type="submit"  id="submit_button" class="btn btn-success"><i class="fas fa-lock"></i> Change</button>
              </div>
        </form>
    </div>

</div>
<div class="col-md-7">Last password change: <time class="timeago" datetime=""><?= $timestamp?></time></div>
</div><!--card body end!-->
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/password_change_form.blade.php ENDPATH**/ ?>