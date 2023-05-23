@include('config')
@include('admin_header')
@include('admin_sidebar')

	<span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
                                <h2>Change Password <i class="fas fa5x fa-lock"></i></h2>
	            			</div>
	            			<div class="col text-right">
	            			</div>
	            		</div>
	            	</div>
                    @include('password_change_form')
			</div>
		</div>
	</div>

</body>
</html>

<script src="<?= JS_URL.'confirm_button.js'?>"></script>
@include('footer_script')
<script>var method_type='/'+$('#changer_id').val();</script>

