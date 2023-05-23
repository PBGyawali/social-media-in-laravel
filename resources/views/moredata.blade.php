  <?php foreach($posts as $key=> $post):?>
			<div class="content d-flex mb-0" >
				<div class="post-wrapper w-100 " id="<?= $post->id; ?>">
					<div class="full-post-div">
						<div class="card-header border-solid bg-transparent border-bottom-0 d-flex justify-content-between align-items-center">
                                <h3 class="d-inline text-dark">
                                <img src="<?= $post->profile_image; ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
                                    <?= $post->name ?>
                                    <?php if ($check):?>
                                    <?php if (!$post->is_anonymous()): ?>
                                        <?php if($userfollowed[$key]): ?>
                                            <?= '<button type="button" class="action_button btn btn-sm btn-success " data-url="'.route('followers').'" data-user_id="'.$id.' " data-action="follow" data-receiver_id="'.$post->user_id.'">UnFollow</button>';?>
                                        <?php else: ?>
                                            <?= '<button type="button" class="action_button btn btn-sm btn-primary " data-url="'.route('followers').'" data-user_id="'.$id.'" data-action="unfollow" data-receiver_id="'.$post->user_id.'"><i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow</button>';?>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endif ?>
                                </h3>
                                <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"
                                        role="menu">
                                        <span class="dropdown-item save" role="presentation" data-id="<?= $post->id ?>">&nbsp;Save Post</span>
                                        <span class="dropdown-item report" data-object="post" role="presentation" data-id="<?= $post->id ?>">&nbsp;Report Post</span>
                                    </div>
                                </div>
                            </div><span class="d-inline"></span>
							<h4 class="post-title mt-3 pl-3 "><?= $post->title; ?></h4>
							<div class="post-body-div pl-3 d-inline-block" >
								 <?= substr($post->body, 0, 200).'...' ?> <p class="post-link"><a class=" hover:text-yellow-500" target="_blank" href="<?= route('single_post', $post->slug); ?>">Read more...</a></p>
							</div>
							<div class="post-info p-3">
                                @include('ratingbox')
							</div>	<!-- div for like dislike ends here  -->
							<div class="row mx-0 pb-5 pl-3">
								<div class="col-md-12 comments-section">
									<!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
									<?php if ($check): ?>
                                        @include('comment_form')
									<?php else: ?>
									<div class="sign-up mt-5" >
										<h3 class="text-center"><a href="<?= route('login'); ?>">Sign in</a> to post a comment</h3>
									</div>
									<?php endif ?>
									<!-- Display total number of comments on this post  -->

									<h3 >
										<span class="comments_count" id="comments_count_<?= $post->id ?>">
											{{$commentscount[$key]>0?'Show':''}} {{$commentscount[$key]}} 
											{{Str::plural('Comment',$commentscount[$key])}}
										</span>
									</h3>
										<!-- comments wrapper -->
									<div id="comments-wrapper_<?= $post->id ?>" class="comments-wrapper">
										<?php if (isset($comments) && $commentscount[$key]>0): ?>
                                            <?php foreach ($comments[$key] as $index=> $comment): ?>
											    @include('comments')
                                            <?php endforeach ?>
											<?php else: ?>
										<h4 class='comment_call' id="comment_call_<?= $post->id?>">Be the first to comment on this post</h4>
										<?php endif ?>
									</div><!-- comments wrapper -->
								</div>
							</div>
                            <?php //endif ?><!-- dont show anything if post is not released except the message -->
					</div><!-- full post-div -->
				</div>	<!-- post-wrapper -->
			</div> <!--content -->
            <?php endforeach?>
