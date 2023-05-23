@include('config')
@include('admin_header')
@include('admin_sidebar',['size'=>'-10'])
@include('message')
  <div class="card">
	<div class="card-header">
		@include('header_card',['element'=>'post','name'=>'management'])
	</div>
	<div class="card-body" id="topic-list-box">
		<div class="table-responsive">
			@include('table',['headers'=>['id','title','username'=>'author','created_at','updated_at','post_status'=>'published',
			auth()->user()->is_admin()?"anonymous":'']])
		</div>
	</div>
</div>



<div id="Modal" class="modal fade" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	  <form method="post" id="form" class="form" enctype="multipart/form-data" action="<?= route('post')?>">
			<div class="modal-content">
			  <div class="modal-header">
					<h4 class="modal-title" id="modal_title">Create Post</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>
			  <div class="modal-body text-left">
					<div class="form-group">
						<div class="row">
						  <label class="col-md-1 text-left">Title</label>
						  <div class="col-md-11">
							  <input type="text" name="title" id="title" class="form-control"  required data-parsley-maxlength="150" data-parsley-trigger="keyup" />
						  </div>
					  </div>
					</div>
					<div class="form-group">
						<div class="row">
						  <label class="col-md-1 text-left">Featured Image</label>
						  <div class="col-md-11">
						  <input type="file" name="featured_image" id="featured_image" class="form-control" />
						  </div>
					  </div>
					</div>
					<div class="form-group">
						<div class="row">
						  <div class="col-md-12 text-left">
						  <textarea name="body" id="body" cols="100%" rows="100%"></textarea>
						  </div>
					  </div>
					</div>
					<div class="form-group">
						<div class="row">
						  <label class="col-md-1 text-left">Publish</label>
							  <div class="col-md-1 text-left">
								  <input type="checkbox" name="post_status" id="publish" value="active" class="form-control" >
							  </div>
							  <?php if(auth()->user()->is_admin()):?>
							  <label class="col-md-2.5 text-left">Post as Anonymous</label>
							  <div class="col-md-1 text-left">
								  <input type="checkbox" name="anonymous" value="active" id="anonymity" class="form-control" >
							  </div>
							  <?php endif?>
						  </div>
					</div>
					<div class="form-group">
						<div class="row">
						  <label class="col-md-1 text-left">Topic</label>
						  <div class="col-md-11">
							  <select name="topic_id" id="topic_id" class="form-control" required>
							  <option value="" selected >Choose topic</option>
							  <?php foreach ($topics as $key => $topic): ?>
							  <option value="<?= $topic->id; ?>" ><?= $topic->name; ?>
							  </option>
							  </div>
							  <?php endforeach ?>
							  </select>
						  </div>
					  </div>
					</div>
			  <div class="modal-footer">
					<button type="submit" class="btn btn-success" value="Approve" >Add</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
	  </form>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
@include('footer_script')

