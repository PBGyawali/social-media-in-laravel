@include('config')
 @include('minimal_header')
 @include('sidebar')
@include('new_message')
	        <div class="col-sm-12 py-4">
	        	<span class="text-center position-absolute w-100"id="message" style="z-index:10"><?php displaymessage('',$errors);?></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
								<h2><?=(isset($post) ) ? 'Edit ' : 'Add ' ?>Post</h2>
	            			</div>
		            		<div class="col-sm-4">

	            			</div>
	            			<div class="col-md-4 text-right">
	            				<a type="button" name="add_post" id="add_post" href="<?=route('article')?>" class="btn btn-success btn-sm" ><i class="fas fa-reply"></i> Return to Post Management</a>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body text-left">

				<form method="POST" enctype="multipart/form-data" action="<?= route('article').'/'.(isset($post)?'update/'.$post->id: 'store');?>">
					<div class="content">
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Title</label>
			            	<div class="col-md-11">
                                <input type="text" name="title" id="title" value="<?= old('title')?old('title'):(isset($post)?$post->title: '' ) ?>"class="form-control"  data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <?php if ($errors->has('title')) echo '<span class="text-danger">'.$errors->first('title').'</span>';?>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Featured Image</label>
			            	<div class="col-md-11">
                            <input type="file" name="featured_image" id="featured_image" class="form-control" />
                            <?php if ($errors->has('featured_image')) echo '<span class="text-danger">'.$errors->first('featured_image').'</span>';?>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<div class="col-md-12 text-left">
                            <textarea name="body" class="formcontrol "id="body" cols="100%" rows="100%" ><?=old('body')?old('body'):(isset($post)?$post->body: '' ) ?></textarea>
                            <?php if ($errors->has('body')) echo '<span class="text-danger">'.$errors->first('body').'</span>';?>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">

				<?php if (auth()->user()->is_editor()): ?>
					<!-- display checkbox according to whether post has been published or not -->
						<label class="col-md-1 text-left">Publish<?=(isset($post) && $post->is_published())?'ed':'' ?></label>
							<div class="col-md-1 text-left">
							<input type="checkbox" name="post_status" id="publish" value="active" <?=old('post_status')=='active'?'checked="checked"':((isset($post) && $post->is_published())?'checked="checked"':'' )?> class="form-control" >
                            <?php if ($errors->has('post_status')) echo '<span class="text-danger">'.$errors->first('post_status').'</span>';?>
                        </div>
				<?php endif ?>
					<label class="col-md-2.5 text-left"><?=(isset($post) && $post->is_anonymous())?'Keep the p':'P' ?>ost as Anonymous</label>
					<div class="col-md-1 text-left">
					<input type="checkbox" name="anonymous" value="active" id="anonymity" <?=old('anonymous')=='active'?'checked="checked"':((isset($post) && $post->is_anonymous())?'checked="checked"':'') ?> class="form-control" >
					</div>
			        </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Topic</label>
			            	<div class="col-md-11">
			            		<select name="topic_id" id="topic_id" class="form-control" >
								<option value="" selected disabled>Choose topic</option>
									<?php foreach ($topics as $key => $topic): ?>
									<option value="<?= $topic->id; ?>"<?= $topic->id==old('topic_id')?"selected":(isset ($post)&& $post->topic->id==$topic->id?" selected ":'') ?> ><?= $topic->name; ?>
									</option>
									</div>
								<?php endforeach ?>
                                </select>
                                <?php if ($errors->has('topic_id')) echo '<span class="text-danger">'.$errors->first('topic_id').'</span>';?>
			            	</div>
			            </div>
		          	</div>
        		<div class="footer text-right">
                <?= csrf_field(); ?>
				<?php if (isset($post)): ?>
					<input type="hidden" name="old_image" value="<?= $post->image; ?>">
					<input type="hidden" name="id" value="<?= $post->id; ?>">
                <?php endif ?>
                <input type="hidden" name="user_id"  value="<?= auth()->id(); ?>" >
                <button type="submit"  class="btn btn-<?=(isset($post) ) ? 'primary' : 'success ' ?>" ><?=(isset($post) ) ? 'Edit ' : 'Add ' ?> Post</button>

        		</div>
    	</form>
				</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>
@include('minimal_footer')
<script type="text/javascript" src="<?= JS_URL.'parsley.min.js'?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<link rel="stylesheet" href="<?= CSS_URL.'parsley.css'?>" >
@include('footer_script')
<script>
	$('#post_form').parsley();
</script>
