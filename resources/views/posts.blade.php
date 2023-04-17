@include('config')
 @include('minimal_header')
 @include('sidebar')
	        <div class="col-sm-12 py-4">
			<span class="text-center position-absolute w-100"id="message" style="z-index:50"></span>
	            <div class="card">
                <div class="card-header" id="form" action="{{route('article')}}">
	            		<div class="row">
	            			<div class="col-sm-6">
	            				<h2>Post Management</h2>
	            			</div>
	            			<div class="col-md-6 text-right">
	            				<a  id="add" href="<?=route('article.create')?>" class="btn btn-success btn-sm" ><i class="fas fa-plus"></i>  Create Post</a>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="table">
	            				<thead>
	            					<tr>
										<th class="title">Title</th>
										<?php if(auth()->user()->is_admin()):?>
										<th class="username">Author</th>
										<?php endif?>
										<th class="views">Views</th>
										<th class="created_at">Created on</th>
										<th class="updated_at">Updated on</th>
										<th class="post_status">Published</th>
										<?php if(auth()->user()->is_admin()):?>
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
	</div>

</body>
</html>


@include('minimal_footer')
<?php include_once ( INCLUDES . 'footer.php') ?>
<script type="text/javascript" src="<?= JS_URL.'datatables.min.js'?>"></script>
<link rel="stylesheet" href="<?= CSS_URL.'datatables.min.css'?>" >
@include('footer_script')
