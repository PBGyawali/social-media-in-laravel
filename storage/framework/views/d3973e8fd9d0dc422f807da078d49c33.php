<form action="<?= route('article')?>" class="reply_form clearfix" id="comment_reply_form_<?= $comment->id ?>" data-id="<?= $comment->id; ?>">
    <textarea class="form-control reply_text" name="reply_text" id="reply_text_<?= $comment->id ?>"class="form-control" cols="30" rows="3"></textarea>
    <button class="btn btn-success btn-sm py-0 pull-right submit-reply float-right" data-id="<?= $comment->id; ?>"data-receiver_id="<?= $comment->user_id; ?>">Submit reply</button>
    <?php if ($check && $check->is_same_user($comment->user_id)):?>
        <button type='button' class="cancel-btn btn btn-sm btn-primary py-0" data-id="<?= $comment->id; ?>">Cancel Edit</button>
    <?php else:?>
        <button type='button'class="cancel-btn btn btn-sm btn-primary py-0" data-id="<?= $comment->id; ?>">Cancel Reply</button>
    <?php endif?>
        <button type='button'class="btn btn-primary btn-sm pull-right update-reply py-0 text-right float-right" id='update_btn' data-id="<?= $comment->id; ?>"style='display: none;'>Update</button>
</form>

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/reply_form.blade.php ENDPATH**/ ?>