<i  class="rating-btn fa fa-thumbs-up like-btn <?= ($check && $userLiked[$key])?'text-primary':'fa-thumbs-o-up'?>"
    data-id="<?= $post->id ?>" data-receiver_id=" <?= $post->user_id; ?>" data-user_id="<?= auth()->id()  ?>">
</i>
    <span class="likes"><?= $Likes[$key];?></span>
<i class="rating-btn fa fa-thumbs-down dislike-btn <?= ($check && $userdisliked[$key])?'text-primary':'fa-thumbs-o-down'?> "
    data-id="<?= $post->id ?>" data-receiver_id="<?= $post->user_id; ?>" data-user_id="<?= auth()->id()?>">
</i>
    <span class="dislikes"><?= $Dislikes[$key];?></span>
    <span><?php if (!$check) echo"<h3>Please Login to Rate the Post</h3>";?></span>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/ratingbox.blade.php ENDPATH**/ ?>