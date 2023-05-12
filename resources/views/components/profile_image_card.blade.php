<div class="card-body text-center  offset-0 ml-0 p-0">
    <span id="user_uploaded_image" class="mt-0 ">
        <a data-fancybox="" href="<?= auth()->user()->profile_image;?>" id="fancybox" data-caption="Your full picture"><img class="rounded-circle mb-0 mt-0 img-fluid profile_image" src="<?= auth()->user()->profile_image;?>" width="150"  >
        </a>
    </span>

    <div class="mb-2 d-inline">
            @if($check->is_verified())
            <i class="fa btn btn-sm  btn-success fa-check-circle">
                <span class="d-none d-md-inline-block">Verified</span>
             </i>
            @else
            <i class="fa btn btn-sm  btn-danger fa-times-circle">
                <span class="d-none d-md-inline-block">Not verified</span>
             </i>               
            @endif 
    </div>
    <div class="col-md-12 text-center">
        <div class="mb-2 d-inline">
            <label for="file_upload" tabindex="1">
                <i class="fa fa-camera upload-button btn btn-primary btn-sm fa fa-camera upload_picture"> 
                    <span id="upload_icon_text" class="d-none d-md-inline-block"> 
                        @if(!$check->has_no_image()) Change @else Upload New @endif   
                    </span> 
                </i>
            </label>
        </div>

        <div class="mb-0 d-inline" id="delete_div">
            <?php if (!$check->has_no_image()):?>
                @include('delete_button')               
            <?php endif ?>
        </div>
        <form id="picture_upload" action="<?= route('user.profile.update',$user->id)?>" method="post" enctype="multipart/form-data" style="display:none;">
            <input type="file" name="profile_image" id="file_upload" class="mb-2 d-block file_upload" data-allowed_file='[<?= '"'.implode('","', ALLOWED_IMAGES) .'"';?>]' data-upload_time="now" accept="<?= "image/".implode(", image/", ALLOWED_IMAGES);?>"  >
            <input type="submit"  value="upload">
        </form>
    </div>
    <progress style="display:none"></progress>
</div>
