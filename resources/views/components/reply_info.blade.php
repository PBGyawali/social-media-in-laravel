<div class="comment-details">
            <a class="comment-name" href="<?= route('user.profileview',$reply->user_id)?>"><?= $reply->username ?></a>
            <span class="comment-date"><?= $reply->created_at; ?></span>
            <p class="comment_value"><?= $reply->body; ?></p>
            <?php if ($check):?>
                <?php if ($check->is_same_user($reply->user_id) || $check->is_admin()):?>
                <button class="delete-btn badge btn-danger " data-id="<?= $reply->id; ?>" data-parent_id="<?= $reply->comment_id; ?>" data-object="replies">Delete</button>
                <?php endif?>
                <?php if ($check->is_same_user($reply->user_id)):?>
                <button class="edit-btn badge btn-primary" data-object="replies" data-parent_id="<?= $reply->comment_id; ?>" data-id="<?= $reply->id; ?>">Edit</button>
                <?php endif?>
                <?php if (!$check->is_same_user($reply->user_id)):?>
                    <button class="reply-btn badge btn-success "  data-object="replies" data-id="<?= $reply->comment_id; ?>">Reply</button>
                <?php endif ?>
            <?php endif ?>
        </div>
