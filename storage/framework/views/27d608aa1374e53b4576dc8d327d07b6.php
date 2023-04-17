<?= $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
?>
				<span class="text-center position-absolute w-100"id="message" style="z-index:50"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
	            				<h2>Post Management</h2>
	            			</div>
	            			<div class="col-sm-4">
	            				<div class="row input-daterange">
	            					<div class="col-md-6">
		            					<input type="date" id="from_date" class="form-control form-control-sm" placeholder="From Date" />
		            				</div>
		            				<div class="col-md-6">
		            					<input type="date" id="to_date" class="form-control form-control-sm" placeholder="To Date"  />
		            				</div>
		            			</div>
		            		</div>
		            		<div class="col-md-2">
	            				<button type="button" name="filter" id="filter" class="btn btn-info btn-sm"><i class="fas fa-filter"></i></button>
	            				&nbsp;
	            				<button type="button" name="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
	            			</div>
	            			<div class="col-md-2 text-right" >
	            				<a href="#" name="export" id="export" class="text-success"><i class="fas fa-file-csv fa-2x"></i></a>
	            				&nbsp;
	            				<button type="button" data-element="Posts" id="add_button" class="btn btn-success btn-sm mr-2" style="margin-top: -15px;"><i class="fas fa-plus"></i>  <span class="d-none d-sm-inline-block">Add new</span></button>
	            			</div>
	            		</div>
	            	</div>

	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="table">
	            				<thead>
	            					<tr>
										<th class="id">POST ID</th>
	            						<th class="title">Title</th>
										<th class="username">Author</th>
										<th class="created_at">Created on</th>
										<th class="updated_at">Updated on</th>
										<th class='post_status'>Published</th>
										<?php if (auth()->user()->is_admin()): ?>
										<th class="anonymous">Anonymous</th>
										<?php endif?>
										<th class="action">Action</th>
	            					</tr>
	            				</thead>
							</table>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>

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
          			<input type="submit"  id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/posts.blade.php ENDPATH**/ ?>