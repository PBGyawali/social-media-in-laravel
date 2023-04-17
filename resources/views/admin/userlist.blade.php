<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
?>
	        	@include('message')
	            <div class="card">
	            	<div class="card-header">
						@include('header_card',['element'=>'user','buttonicon'=>'user-plus','exporturl'=>route('user')])
						<div class="row">
	            			<div class="col text-center font-weight-bold">
							Hide Chosen Row
							</div>
						</div>
						<div class="row">
	            			<div class="col text-left-justified border border-dark">
								{{-- checkbox to hide or show column --}}
								@include('table-checkbox',['columns'=>['Id','Profile Image','Username','Email','Full name','User type','Status','Action']])
							</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
						@include('table',['headers'=>['id','profile_image','username','email','fullname','user_type','user_status']])
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
          			<input type="submit"  id="verify_button" class="btn btn-success" value="Approve" />
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
          			<input type="submit"  id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>


@include('detail_modal',['id'=>'details_form','name'=>'user','submit'=>'true'])

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
          			<input type="submit"  id="action_submit_button" class="btn btn-success" value="Disable" />
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
@include('footer_script')


