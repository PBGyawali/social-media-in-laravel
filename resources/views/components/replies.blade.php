    <div class="commentbox reply clearfix"><!-- reply -->
        <div id="profilepic_<?= $reply->id?>">
            <img src="<?= $reply->profile_image ?>" alt="" height="40px" width="40px" class="profile_pic rounded-circle">
        </div>
        @include('reply_info')
    </div>
