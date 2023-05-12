<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>
	            <div class="card">
	            	<div class="card-header">
						<?php echo $__env->make('header_card',['element'=>'ticket','name'=>'management','noreport'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<div class="row">
	            			<div class="col text-center font-weight-bold">
							Hide Chosen Row
							</div>
						</div>
						<div class="row">
	            			<div class="col text-left-justified border border-dark">
								<?php echo $__env->make('table-checkbox',['columns'=>['status','title','email','date created','action']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
						<?php echo $__env->make('table',['headers'=>['status_icon'=>'status','title','email','created_at'=>'date created']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>
<div id="Modal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" class="form" id="form" action="<?= route('ticket')?>">
      		<div class="modal-content">
        		<div class="modal-header">
					  <h4 class="modal-title" id="modal_title">Create Ticket</h4>

          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Ticket name</label>
			            	<div class="col-md-6">
			            		<input type="text" name="title" placeholder="Title" id="title" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s0-9]+$/" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Email</label>
			            	<div class="col-md-6">
			            		<input type="text" name="email" placeholder="johndoe@example.com" id="email" class="form-control" required data-parsley-type="email" data-parsley-trigger="on change" />
			            	</div>
			            </div>
					  </div>

	          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Message</label>
			            	<div class="col-md-6">
							<textarea name="msg" placeholder="Enter your message here..." id="msg" class="form-control"  required  data-parsley-trigger="on change"></textarea>
			            	</div>
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

<div id="detailModal" class="modal fade">
  	<div class="modal-dialog">
	  <form method="post" action="<?=route('ticket.comments.create')?>"id="comment_form" >
      		<div class="modal-content">
        		<div class="modal-header ">
					  <h4 class="modal-title text-center " id="viewmodal_title">
						<span id="titleview"></span> 
						<span id="statusview"class=" text-danger ">()</span>
					 </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
					  <div class="row">
					  <label class="col-md-12 text-center">Ticket data</label> </div>
					  <div class="row">
					  <div class="col-md-12">
						<p> Created on: <span id="dateview"></span></p>
						<p id="messageview"></p>
						</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Email: </label>
			            	<div class="col-md-6 text-left">
							<span id="emailview"></span>
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
							<div class="row">
								<label class="col-md-12 text-center">Change status</label>
							</div>
							<div class="row">
								<div class="col-md-12">
										<?php if(auth()->user()->is_admin()): ?>
											<button type="button" name="closed_button" class="btn btn-secondary status" data-status="closed" data-id="">Closed</button>
										<?php endif; ?>
										<button type="button"  class="btn btn-success status" data-status="resolved" data-id="">Resolved</button>
										<button type="button"  class="btn btn-danger status" data-status="pending" data-id="">Pending</button>
										<button type="button" class="btn btn-warning status" data-status="on-hold" data-id="">On hold</button>
										<?php if(auth()->user()->is_owner()): ?>
											<button type="button" name="closed_button" class="btn btn-primary status" data-status="open" data-id="">Open</button>
										<?php endif; ?>
								</div>
							</div>
					  </div>

					  <div class="form-group">
		          		<div class="row">
							<label class="col-md-12 text-center">Comments</label>
							<div class="col-md-12 comments_view text-center" style="display:none"><h5><i class="fa fa-spinner fa-pulse "></i> Loading comments...</h5></div>
			            	<div class="col-md-12 allcomments object_details" id="allcomments">
			            	</div>
			            </div>
					  </div>

	          	<div class="form-group">
		          		<div class="row">
			            	<div class="col-md-12">
                            <textarea name="msg" placeholder="Enter comments here..." id="ticketcomments" value=""class="form-control tickets"  required  data-parsley-trigger="on change"></textarea>
                            <input type="hidden" name="ticket_id" id="ticket_id">
							 </div>
			            </div>
					  </div>
        		</div>
        		<div class="modal-footer">
          			<input type="submit"  id="comment_submit_button" class="btn btn-success" value="Post comment" />
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<script src="<?= JS_URL?>tickets.js"></script>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/tickets.blade.php ENDPATH**/ ?>