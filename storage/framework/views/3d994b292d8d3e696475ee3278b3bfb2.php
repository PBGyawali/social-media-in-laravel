<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php  
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
?>
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
                    <?php echo $__env->make('password_change_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
		</div>
	</div>

</body>
</html>

<script src="<?= JS_URL.'confirm_button.js'?>"></script>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>var method_type='/'+$('#changer_id').val();</script>

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/change_password.blade.php ENDPATH**/ ?>