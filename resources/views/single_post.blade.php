@include('config')
@include('minimal_header')
<?php  include(INCLUDES.'sidebar.php'); ?>
  <link rel="stylesheet" type="text/css" href="<?php  echo CSS_URL?>post.css">
</head>
<body>
<div class="container-fluid mt-3 whitespace-normal break-all" >
	<div class="row mx-0">
		<div class="col-md-1 mx-0 px-0">
			<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5facd05263b0cd00123cbb3f&product=sticky-share-buttons" async="async"></script>
		</div>
		<div class="col-md-9  ">
			<div class="content d-flex" >
				<div class="post-wrapper w-100">
					<div class="full-post-div pl-3 pt-2 min-vh-100">
                        <?php if ($posts->isEmpty()): ?>
                            <h1 class="w-100 text-center position-absolute px-4 inset-1/2" style="
                                 transform: translate(-50%, -50%)">
                                Sorry... The post that you are trying to find does not exist in our system.
                            </h1>
						<?php else: ?>
						<?php foreach($posts as $key=> $post):?>
						<?php if ( !$post->is_published()): ?>
                            <h1 class="w-100 text-center position-absolute px-4 inset-1/2" style="
                                transform: translate(-50%, -50%)">
                                Sorry... This post is not available. Either the author made it private or it has been
                                hidden due to violation of our community guidlines.
                            </h1>
						<?php else: ?>
                            <form id="postviews" action="<?= route('postlogs')?>" method="post">
                                <?= csrf_field(); ?>
								<input type="hidden" id="views" value="<?= $post->id; ?>">
								<input type="hidden" id="loginid" value="<?= $user_id ?>">
								<input type="hidden" id="receiverid" value="<?php if ($check) echo $post->user_id ?>">
                                <input type="hidden" id="action_server" value="<?= route('article')?>" />
                                <input type="hidden" id="rating_server" value="<?= route('ratings')?>" />
							</form>
							<h2 class="post-title text-center"><?= $post->title; ?></h2>
							<h4 class="post-title d-inline">Author:
                            <?= $post->name ?>
							</h4>
							@if ($check)
								<?php if (!$post->is_anonymous()): ?>
                                    <?php if ($userfollowed[$key])
                                    echo '<button type="button" class="action_button btn btn-sm btn-success " data-url="'.route('followers').'" data-user_id="'.$user_id.' " data-action="follow" data-receiver_id="'.$post->user_id.'">UnFollow</button>';
										else
											echo '<button type="button" class="action_button btn btn-sm btn-primary " data-url="'.route('followers').'" data-user_id="'.$user_id.'" data-action="unfollow" data-receiver_id="'.$post->user_id.'"><i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow</button>';
									 ?>
								<?php endif ?>
							@endif

							<h5 class="post-created">Created on: <?= $post->created_at; ?></h5>
							@if($post['updated_at'])
							<h5 class="post-updated">Last updated: <?= $post->post_update?></h5>
							@endif
							<h5 class="post-view">Total views: <?= $post->views; ?></h5>
							<div class="post-body-div m-auto mt-3 pr-3  text-justify" style="word-wrap: break-word;white-space:normal">
							<p class="comment_value"><?= $post->body ?></p>
							</div>
							<div class="post-info p-3">
                                @include('ratingbox')
							</div>	<!-- div for like dislike ends here  -->
							<div class="row mx-0 pb-5">
								<div class="col-md-12 commtion">
	                                <!-- if user is not signed in, tell them to sign in else present comment form -->
                                    <?php if ($check): ?>
                                        @include('comment_form')
                                    <?php else: ?>

									<div class="sign-up mt-5" >
										<h3 class="text-center"><a href="<?= route('login'); ?>">Sign in</a> to post a comment</h3>
									</div>
									<?php endif ?>
									<!-- Display total number of comments on this post  -->
									<h3 ><span class="comments_count" id="comments_count_<?= $post->id ?>"><?= ($commentscount[$key]>0?'<span class="comments_count_show" id="comments_count_show'.$post->id.'">Show </span>'.$commentscount[$key]:$commentscount[$key]); ?> Comment<?= ($commentscount[$key]>1?'s':''); ?></span></h3>
										<!-- comments wrapper -->
									<div id="comments-wrapper_<?= $post->id?>" class="comments-wrapper">
                                        <?php if (isset($comments) && $commentscount[$key]>0): ?>
                                                @foreach ($comments[$key] as $index=> $comment)
                                                    @include('comments')
                                                @endforeach
											<?php else: ?>
										<h2 class="comment_call" id="comment_call_<?= $post->id?>">Be the first to comment on this post</h2>
										<?php endif ?>
									</div><!-- comments wrapper -->
								</div>
							</div>
							<?php endif ?>
							<?php endforeach?>
							<?php endif ?><!-- dont show anything if post is not released except the message -->
					</div><!-- full post-div -->
				</div>	<!-- post-wrapper -->
			</div> <!--content -->

		</div>
			<div class="col-md-2 mx-0 px-0">
						<div class="post-sidebar">
							<div class="card w-100">
								<div class="card-header text-center text-white p-0">
									<h2 class="bg-primary my-0">Topics</h2>
								</div>
								<div class="card-content">
									@foreach($topics as $topic)
										<a href="<?= route('topic.show',$topic->id)?>"><?= $topic->name?></a>
									@endforeach
								</div>
							</div>
                        </div>
        @include('minimal_footer')
						@if ($check)
						    @include('chatbox')
						@endif</div>
	</div></div><!-- container div end -->
</body>
</html>

<?php include_once(INCLUDES . 'footer.php') ?>
<script type="text/javascript" src="<?= JS_URL?>comment_system.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>user_action.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>visitor_detail.js"></script>
@include('footer_script')
