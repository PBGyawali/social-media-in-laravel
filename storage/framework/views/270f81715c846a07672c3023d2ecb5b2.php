
    <div class="comment commentbox clearfix" id="comment_<?= $comment->id?>" <?= isset($display)?:'style="display:none"'?> >
        <div class="comment-details " id="comment__details_<?= $comment->id?>">
            <div id="profilepic_<?= $comment->id?>">
                <img src="<?= $comment->profile_image ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
            </div>
         <?php echo $__env->make('comment_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div><!-- // comment-details -->
                <!-- reply form -->
                <?php echo $__env->make('reply_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="replies_wrapper_<?= $comment->id; ?>">

                <?php if (isset($replies) && $replies!=null): ?>

                    <?php foreach ($replies[$index]  as $reply): ?>
                        <?php echo $__env->make('replies', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
    </div><!-- // comment -->


<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/comments.blade.php ENDPATH**/ ?>