
<?= $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
$row =$info;
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
$check=auth()->user();
?>
<div class="d-flex flex-column " id="content-wrapper">
    <div id="content">
        <div class="container-fluid ">
            <div class="col-12 p-0">
                <div class="d-flex flex-column" >
                    <span id="message"></span>

                    <!-- Tabs navs -->
                    <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active tabbutton" data-id="ex1-tabs-0" data-mdb-toggle="tab" href="#ex1-tabs-0" role="tab" aria-controls="ex1-tabs-0" aria-selected="true">Profile Settings</a>
                        </li>
                    <?php  if($check->is_owner()):?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tabbutton" data-id="ex1-tabs-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="false">Website Settings</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link tabbutton" data-id="ex1-tabs-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Owner Settings</a>
                        </li>
                    <?php  endif?>
                    </ul>
                    <!-- Tabs navs -->

                    <!-- Tabs content -->
                    <div class="tab-content" id="ex1-content">
                        @include('profile_settings')
                        
                        <?php  if($check->is_owner()):?>
                            <div class="tab-pane show" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                            <form method="post" class="website form settings setting_form" id="website_form" enctype="multipart/form-data" action="<?= route('settings_update').'/'.$info->website_id; ?>">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="m-0 font-weight-bold text-primary">Website Settings</h6>
                                            </div>
                                            <div clas="col text-right" >
                                                <button type="submit" name="website_edit_button" id="website_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                                                &nbsp;&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- form left side -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Website Name</label>
                                                    <input type="text" name="website_name" id="website_name"  value="<?= ($row['website_name']) ?>"class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Website Email</label>
                                                    <input type="email" name="website_email" id="website_email" value="<?= $row['website_email']; ?>"class="form-control" data-parsley-type="email" data-parsley-trigger="keyup"/>
                                                </div>

                                                <div class="form-group">
                                                    <label>Website Address</label>
                                                    <input type="text" name="website_address" id="website_address" value="<?= $row['website_address']; ?>" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>User Target</label>
                                                    <input type="number" name="user_target" id="user_target" value="<?= $row['user_target']; ?>" required class="form-control" />
                                                </div>
                                            </div>
                                            <!-- form right side -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Website Tagline</label>
                                                    <input type="text" name="website_tagline" id="website_tagline"value="<?= $row['website_tagline']; ?>"  class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Theme</label>
                                                    <select name="website_theme" id="website_theme" class="form-control" required>
                                                    <option value=""selected disabled hidden>Select Theme</option>
                                                    <option value="white" <?= ($row['website_theme'] == 'white'? 'selected="selected"': '' );?>>White</option>
                                                    <option value="dark"  <?= ($row['website_theme'] == 'dark' ? 'selected="selected"': '' );?>>Dark</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Timezone</label>
                                                    <?= $Timezone_list;?>
                                                </div>
                                                <div class="form-group">
                                                    <label>Secret Paassword</label>
                                                    <input type="password" name="secret_password"  class="form-control password" />
                                                </div>
                                                <div class="form-group">
                                                <label>Select Logo</label><br />
                                                <input type="file" name="website_image" id="website_logo"  class="image file_upload" data-allowed_file='[<?= '"' . implode('","', ALLOWED_IMAGES) . '"'?>]' data-upload_time="later" accept="<?= "image/" . implode(", image/", ALLOWED_IMAGES);?>"/>
                                                <br />
                                                <span class="text-muted">Only <?php  echo join(' and ', array_filter(array_merge(array(join(', ', array_slice(ALLOWED_IMAGES, 0, -1))), array_slice(ALLOWED_IMAGES, -1)), 'strlen'));?> extensions are supported</span><br />
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div><!-- end of 2nd tab div content -->

                            <div class="tab-pane show" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">

                            <form method="post" class="owner settings setting_form form" id="owner_form" enctype="multipart/form-data" action="<?= route('settings_update').'/'.$info->website_id; ?>">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="m-0 font-weight-bold text-primary">Owner Settings</h6>
                                            </div>
                                            <div clas="col text-right" >
                                                <button type="submit" name="owner_edit_button" id="owner_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                                                &nbsp;&nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- form left side -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Owner Name</label>
                                                    <input type="text" name="owner_name" id="owner_name"  value="<?= ($row['owner_name']) ?>"class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Owner Email</label>
                                                    <input type="email" name="owner_email" id="owner_email" value="<?= $row['owner_email']; ?>"class="form-control" data-parsley-type="email" data-parsley-trigger="keyup"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Owner Contact No.</label>
                                                    <input type="text" name="owner_contact_no" id="owner_contact_no" value="<?= $row['owner_contact_no']; ?>"class="form-control" />
                                                    <span class="text-muted">Enter numbers excluding country codes and '0' if it is the starting digit</span><br />
                                                </div>
                                                <div class="form-group">
                                                    <label>Owner Address, House no</label>
                                                    <input type="text" name="owner_address" id="owner_address" value="<?= $row['owner_address']; ?>" class="form-control" />
                                                </div>
                                            </div>
                                            <!-- form right side -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Owner postalcode, City</label>
                                                    <input type="text" name="owner_postal_code" id="owner_postal_code"value="<?= $row['owner_postal_code']; ?>"  class="form-control" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Owner Country</label>
                                                    <?= $Country_list;?>
                                                </div>
                                                <div class="form-group">
                                                <label>Select Image</label><br />
                                                <input type="file" name="owner_photo" id="owner_image"  class="image file_upload" data-upload_time="later" accept="<?= "image/" . implode(", image/", ALLOWED_IMAGES);?>"/>
                                                <br />
                                                <span class="text-muted">Only <?php  echo join(' and ', array_filter(array_merge(array(join(', ', array_slice(ALLOWED_IMAGES, 0, -1))), array_slice(ALLOWED_IMAGES, -1)), 'strlen'));?> extensions are supported</span><br />
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                    <?php  endif?>
                        </div>
                    <!-- last two div above belongs to Tabs content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer_script')
<script>
    $('.tabbutton').on('click', function(event){
        event.preventDefault();
        var tabpane=$(this).data('id');
        $('.tabbutton').removeClass('active');
        $(this).toggleClass('active');
        $('.tab-pane').hide();
        $('#'+tabpane).show();
    });
</script>
