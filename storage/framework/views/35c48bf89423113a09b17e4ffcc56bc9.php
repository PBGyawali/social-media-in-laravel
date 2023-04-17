    <div class="tab-pane show active" id="ex1-tabs-0" role="tabpanel" aria-labelledby="ex1-tab-0">
        <form method="post" class="profile settings form no-reset" id="profile_setting_form" enctype="multipart/form-data" action="<?= route('userlog').'/'.auth()->id(); ?>">
          <div class="card shadow mb-4">
              <div class="card-header py-3">
                  <div class="row">
                      <div class="col">
                          <h6 class="m-0 font-weight-bold text-primary">Profile Settings</h6>
                      </div>
                      <div clas="col text-right" >
                          <button type="submit" name="profile_edit_button" id="profile_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                          &nbsp;&nbsp;
                      </div>
                  </div>
              </div>
              <div class="card-body">
                  <div class="row">
                      <!-- form left side -->
                      <div class="col-md-4">

                      <h6 class="card-header"> Notifications </h6>

                      <div class="list-group-item d-flex justify-content-between align-items-center"> Someone follows you
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="follows" class="switcher-input" checked="">
                                </label>
                              </div>



                              <div class="list-group-item d-flex justify-content-between align-items-center"> Someone mentions you
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="mentions" class="switcher-input" checked="">
                                  </label>
                              </div>

                              <div class="list-group-item d-flex justify-content-between align-items-center"> Someone sends you a message
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="message" class="switcher-input" checked="">
                                </label>
                              </div>


                      </div><!-- column wrapper div -->
                      <!-- form center part -->
                      <div class="col-md-4">
                      <h6 class="card-header"> Post Notifications </h6>

                          <div class="list-group-item d-flex justify-content-between align-items-center"> Someone update a post
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="update_post" class="switcher-input" checked="">
                                </label>
                              </div>



                              <div class="list-group-item d-flex justify-content-between align-items-center"> Someone adds new posts
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="new_post" class="switcher-input" checked="">
                                </label>
                              </div>
                              <div class="list-group-item d-flex justify-content-between align-items-center"> Someone comments on your post
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="comments" class="switcher-input" checked="">
                                </label>
                              </div>
                              <div class="list-group-item d-flex justify-content-between align-items-center"> Someone Likes your post
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="likes" class="switcher-input" checked="">
                                </label>
                              </div>
                      </div><!-- column wrapper div -->
                       <!-- form right side -->
                      <div class="col-md-4">

                          <h6 class="card-header"> Posts &amp; Trending</h6>
                          <div class="list-group-item d-flex justify-content-between align-items-center"> Top posts this week
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="trending_post" class="switcher-input" checked="">
                                </label>
                              </div>

                              <div class="list-group-item d-flex justify-content-between align-items-center"> Top topic this week
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="top_topic" class="switcher-input" checked="">
                                </label>
                              </div>


                              <div class="list-group-item d-flex justify-content-between align-items-center"> Rating reminders
                                <label class="switcher-control switcher-control-success">
                                  <input type="checkbox" name="rating" class="switcher-input">
                                </label>
                              </div>
                      </div>

                  </div>
                                
                  <div class="row">
                      <!-- form left side -->
                      <div class="col-md-4">
                      <h6 class="card-header"> Login to </h6>
                                <select name="login" id="login_menu" class="form-control" required>
                              <option value=""selected disabled hidden>Select login Menu</option>
                              <option value="dashboard" <?= ($logs->login == 'dashboard'? 'selected="selected"': '' );?>>Dashboard</option>
                              <option value="home"  <?= ($logs->login== 'home' ? 'selected="selected"': '' );?>>Home</option>
                              </select>
                      </div>
                  </div>
              </div>
          </div>
      </form>
        </div><!-- end of 1st tab div content -->
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/profile_settings.blade.php ENDPATH**/ ?>