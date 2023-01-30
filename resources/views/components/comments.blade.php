
    <div class="comment commentbox clearfix" id="comment_<?= $comment->id?>" <?= isset($display)?:'style="display:none"'?> >
        <div class="comment-details " id="comment__details_<?= $comment->id?>">
            <div id="profilepic_<?= $comment->id?>">
                <img src="<?= $comment->profile_image ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
            </div>
         @include('comment_info')
    </div><!-- // comment-details -->
                <!-- reply form -->
                @include('reply_form')
            <div class="replies_wrapper_<?= $comment->id; ?>">

                <?php if (isset($replies) && $replies!=null): ?>

                    <?php foreach ($replies[$index]  as $reply): ?>
                        @include('replies')
                    <?php endforeach ?>
                <?php endif ?>
            </div>
    </div><!-- // comment -->


