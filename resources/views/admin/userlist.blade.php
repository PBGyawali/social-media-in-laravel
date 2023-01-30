<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
?>
	        	<span class="text-center position-absolute w-100"id="message" style="z-index:50"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
	            				<h2>User Area</h2>
	            			</div>
	            			<div class="col-sm-4">
	            				<div class="row ">
	            					<div class="col-md-6">
		            					<input type="date" id="from_date" class="form-control form-control-sm" placeholder="From Date"  />
		            				</div>
		            				<div class="col-md-6">
		            					<input type="date" id="to_date" class="form-control form-control-sm" placeholder="To Date"  />
		            				</div>
		            			</div>
		            		</div>
		            		<div class="col-md-2">
	            				<button type="button"  id="filter" class="btn btn-info btn-sm"><i class="fas fa-filter"></i></button>
	            				&nbsp;
	            				<button type="button" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
	            			</div>
	            			<div class="col-md-2 text-right" >
	            				<button data-url="<?= ''?>" id="export" class="text-success"><i class="fas fa-file-csv fa-2x"></i></button>
	            				&nbsp;
	            				<button type="button"  id="add_button" data-element="User" class="btn btn-success btn-sm" style="margin-top: -15px;"><i class="fas fa-user-plus"></i></button>
	            			</div>
						</div>
						<div class="row">
	            			<div class="col text-center font-weight-bold">
							Hide Chosen Row
							</div>
						</div>
						<div class="row">
	            			<div class="col text-left-justified border border-dark">
                                <?php $columnname=array('Id','Profile Image','Username','Email','Full name','User type','Status','Action');
                                foreach($columnname as $key=> $column)
                                echo ' <input type="checkbox" class=toggle data-column="'.$key.'"> '. $column;
                                ?>

								</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="table">
	            				<thead>
	            					<tr>
									<th class="id">ID </th>
										<th class="profile_image">Profile Image</th>
	            						<th class="username">User Name</th>
										<th class="email">Email</th>
										<th class="fullname">Full name</th>
										<th class="user_type">User Type</th>
										<th class="user_status">Status</th>
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

<div id="detailsModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="details_form" class="form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="detail_modal_title"><i class="fas fa-eye"></i> User Details</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
                    <span id="object_details"></span>
        		<div class="modal-footer">
          			<input type="submit"  id="detail_submit_button" class="btn btn-success" value="Save" />
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
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
<?php
include_once(LAYOUTS.'footer.php');
?>


