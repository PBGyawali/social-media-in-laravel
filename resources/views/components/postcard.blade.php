<div class="col-xs-12 col-sm-6 col-md-4 mb-5">
    <a href="<?=route('single_post',$post->slug)?>">
        <div class="card mb-5 h-100">
            <div class="img-wrap">
                <?php if($key==0):?>
                    <span class="badge badge-danger position-absolute"> NEW </span>
                <?php endif?>
                <img src="<?= $post->post_image; ?>" height="200" width="100%"  />
                <?php if (isset($button)): ?>
                <a  href="<?= route('topic.show',$post->topic->id)?>"
                    target='_blank' class="btn category float-right"> <?= $button?>
                </a>
                <?php endif ?>
            </div> <!-- img-wrap.// -->
        <div class="card-body">
        <a href="{{route('single_post',$post->slug)}}"><h5 class="card-title text-warning"><?= $post->title?></h5></a>

            <p class="card-text">
            <span class="text-secondary">Author: <?= $post->name ?>
                </span></p><p> <span class="text-green-800"><?= $post->created_at; ?></span></p>
                <a href="{{route('single_post',$post->slug)}}">
                    <p class="text-primary">
                        <span class=" bottom-0 float-right mr-1">Read more...</span>
                    </p>
                </a>
        </div>
        <div class="card-footer">
            <small class="text-secondary">Last updated: <?= $post->post_update?></small>
        </div>
        </a>
        </div>
    </div>
