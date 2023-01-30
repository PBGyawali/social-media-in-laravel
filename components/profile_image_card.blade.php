<div class="card-body text-center  offset-0 ml-0 p-0">
    <span id="user_uploaded_image" class="mt-0 ">
        <a data-fancybox="" href="<?= $profileimage;?>"data-caption="Your full picture"><img class="rounded-circle mb-0 mt-0 img-fluid" src="<?= $profileimage;?>" width="150"  >
        </a>
    </span>

    <div class="mb-2 d-inline">
        <?= '<i class="fa btn btn-sm '.($check->is_verified()?'btn-success fa-check-circle"> <span class="d-none d-md-inline-block"> Verified</span>':'btn-danger fa-times-circle">
        <span class="d-none d-md-inline-block">Not verified</span>').'</i>';
        ?>
    </div>
    <div class="col-md-12 text-center">
        <div class="mb-2 d-inline">
            <label for="file_upload" tabindex="1"><i class="fa fa-camera upload-button btn btn-primary btn-sm fa fa-camera upload_picture"> <span id="upload_icon_text" class="d-none d-md-inline-block"> <?php if (!!$check->has_no_image()) echo" Change"; else echo " Upload New"; ?>   </span> </i></label>
        </div>

        <div class="mb-0 d-inline" id="delete_div">
            <?php if (!$check->has_no_image()):?>
                <button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> <span class="d-none d-md-inline-block">Delete</span></button>
            <?php endif ?>
        </div>
        <form id="picture_upload" action="<?= route('user.profile.update',$user->id)?>" method="post" enctype="multipart/form-data" style="display:none;">
            <input type="hidden" name="old_image" class="profile_image" id="profile_image" value="<?php  echo $user["profile_image"] ?>" />
            <input type="file" name="profile_image" id="file_upload" class="mb-2 d-block file_upload" data-allowed_file='[<?= '"'.implode('","', ALLOWED_IMAGES) .'"';?>]' data-upload_time="now" accept="<?= "image/".implode(", image/", ALLOWED_IMAGES);?>"  >
            <input type="submit"  value="upload">
        </form>
    </div>
    <progress style="display:none"></progress>
</div>
