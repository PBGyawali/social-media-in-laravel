<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
?>
			<span class="text-center position-absolute w-100"id="message" style="z-index:50"></span>
	            <div class="card">
	            	<div class="card-header">
						<?php echo $__env->make('header_card',['element'=>'topic','name'=>'management','noreport'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
	            	<div class="card-body" id="topic-list-box">
						<?php echo $__env->make('table',['headers'=>['id','name'=>'Topic name']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>

<div id="Modal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post"  class="form" id="form" action="<?= route('topic')?>">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Topic</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Topic Name</label>
			            	<div class="col-md-6">
			            		<input type="text" name="name" id="topic_name" class="form-control"  data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>

        		<div class="modal-footer">
          			<input type="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/topics.blade.php ENDPATH**/ ?>