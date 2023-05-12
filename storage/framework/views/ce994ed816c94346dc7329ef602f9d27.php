<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	        	<?php echo $__env->make('message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            <div class="card">
	            	<div class="card-header">
						<?php echo $__env->make('header_card',['element'=>'user','buttonicon'=>'user-plus',
                        'exporturl'=>route('user.csv',['from_date'=>':from_date','to_date'=>':to_date'])], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<div class="row">
	            			<div class="col text-center font-weight-bold">
							Hide Chosen Row
							</div>
						</div>
						<div class="row">
	            			<div class="col text-left-justified border border-dark">
								
								<?php echo $__env->make('table-checkbox',['columns'=>['Id','Profile Image','Username','Email','Full name','User type','Status','Action']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
						<?php echo $__env->make('table',['headers'=>['id','profile_image','username','email','fullname','user_type','user_status']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</body>
</html>

<div id="verifyModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="verify_form" class="form"  action="" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="verify_modal_title">User Status</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Verify Badge</label>
			            	<div class="col-md-8">
			            		<select name="verified" id="verify_type" class="form-control" required>
			            			<option value="" disabled  selected hidden>Select Verify type</option>
									<option value="yes" >Verify User</option>
									<option value="no" >Remove Verify</option>
			            		</select>
			            	</div>
			            </div>
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<button type="submit"  id="verify_button" class="btn btn-success" value="Approve" >Approve</button>
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="Modal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="form" class="form" action="<?= route('user');?>" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add User</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">User Name</label>
			            	<div class="col-md-8">
			            		<input type="text" name="username" id="username" value="" class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9\s_.]+$/" data-parsley-maxlength="150" data-parsley-trigger="on change" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"> Email</label>
			            	<div class="col-md-8">
			            		<input type="email" name="email" id="email" class="form-control" required  data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="on blur" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group" id="password_section">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Password</label>
			            	<div class="col-md-8">
			            		<input type="text" name="password" id="password" class="form-control"  data-parsley-minlength="6"  data-parsley-trigger="on change" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">First name</label>
			            	<div class="col-md-8">
			            		<input type="text"  name="first_name" id="first_name" class="form-control"  data-parsley-maxlength="100" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Last name</label>
			            	<div class="col-md-8">
			            		<input type="text"  name="last_name" id="last_name" class="form-control" data-parsley-maxlength="100" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
		          	</div>
					  <div class="form-group">
						<div class="row">
						  <label class="col-md-4 text-right">sex</label>
						  <div class="col-md-8">							 
							  <input type="radio" name="sex" id="" value="male">male
							  <input type="radio" name="sex" id="" value="female">female
							  <input type="radio" name="sex" id="" value="other">other
							  <input type="radio" name="sex" id="" value="not mentioned">not mentioned
						  </div>
					  </div>
					</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">User_type</label>
			            	<div class="col-md-8">
			            		<select name="user_type" id="user_type" class="form-control" >
									<option value="" disabled  selected hidden>Select User type</option>
									<option value="owner" >Owner</option>
									<option value="admin" >Admin</option>
									<option value="editor" >Editor</option>
									<option value="user" >User</option>
			            		</select>
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


<?php echo $__env->make('detail_modal',['id'=>'details_form','name'=>'user','submit'=>'true'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div id="actionModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="action_form" action=""class="form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="action_modal_title"> Disable User</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
					  <div class="form-group" id="remarks_div">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Remarks:</b></label>
			            	<div class="col-md-8">
			            		<textarea name="remarks" id="action_remarks" class="form-control" data-parsley-maxlength="400" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
					  </div>
        		</div>
        		<div class="modal-footer">
                    <button type="submit" class="btn btn-success" value="Approve" >Disable</button>
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/userlist.blade.php ENDPATH**/ ?>