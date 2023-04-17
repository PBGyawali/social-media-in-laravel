<div class="comment_info">
    <a class="comment-name" href="<?= route('user.profileview',$comment->user_id)?>"><?= $comment->username ?></a>
    <span class="comment-date"><?= $comment->created_at; ?></span>
    <p class="comment_value"><?= $comment->body; ?></p>
    <?php if ($check):?>
        <?php if ($check->is_same_user($comment->user_id)):?>
        <button class="edit-btn badge btn-primary" data-object="comments" data-parent_id="<?= $comment->id; ?>"data-id="<?= $comment->id; ?>">Edit</button>
        <?php else:?>
            <button class="reply-btn badge btn-primary" data-id="<?= $comment->id; ?>" data-object="comments" data-receiver_id="<?= $comment->user_id; ?>">Reply</button>
        <?php endif?>
        <?php if ($check->is_same_user($comment->user_id) || $check->is_admin()):?>
            <button class="delete-btn  badge btn-danger" data-id="<?= $comment->id; ?>"  data-parent_id="<?=$comment->post_id?>" data-object="comments">Delete</button>
        <?php endif?>
    <?php endif?>
</div>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/comment_info.blade.php ENDPATH**/ ?>