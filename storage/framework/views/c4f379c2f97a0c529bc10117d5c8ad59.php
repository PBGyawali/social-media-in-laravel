<form class="comment_form clearfix" action="<?= route('comments')?>" method="post" id="comment_form" style="display:none">
    <?= csrf_field(); ?>
    <textarea name="body" placeholder="Start the discussion" id="comment_text_<?= $post->id ?>" data-emojiable="true"
    data-emoji-input="unicode" class="form-control comment_text" cols="30" rows="3"></textarea>
    <input type="hidden" name="post_id" class="post_id" id="post_id" value="<?= $post->id ?>">
    <input type="hidden" name="user_id" class="user_id" id="user_id" value="<?= $post->user_id ?>">
    <button class="submit_comment btn btn-success btn-sm float-right" type="submit" data-user_id="<?= $post->user_id ?>" data-id="<?= $post->id ?>" id="submit_comment">Submit comment</button>
</form>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/comment_form.blade.php ENDPATH**/ ?>