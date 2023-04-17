    <div class="commentbox reply clearfix"><!-- reply -->
        <div id="profilepic_<?= $reply->id?>">
            <img src="<?= $reply->profile_image ?>" alt="" height="40px" width="40px" class="profile_pic rounded-circle">
        </div>
        <?php echo $__env->make('reply_info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/replies.blade.php ENDPATH**/ ?>