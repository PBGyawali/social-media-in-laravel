@include('config')
@include('admin_header')
@include('admin_sidebar')
	            <div class="card">
	            	<div class="card-header">
						@include('header_card',['element'=>'topic','name'=>'management','noreport'=>true])
					</div>
	            	<div class="card-body" id="topic-list-box">
						<div class="table-responsive">
							@include('table',['headers'=>['id','name'=>'Topic name']])
						</div>
						
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
                    <button type="submit" class="btn btn-success" value="Approve" >Disable</button>
          			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
@include('footer_script')

