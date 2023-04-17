<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
$email=session()->has('email')?session('email'):'';
$sex=$user->sex;$facebook= $user->facebook;$twitter=$user->twitter;
    $googleplus=$user->googleplus;$firstname=$user->first_name;$lastname= $user->last_name;
    $email=$user->email;
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
?>
	    <span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>
	            <div class="card">
	            	<div class="card-header md-3 p-0 no-border">
	            		<div class="row mb-0">
	            			<div class="col">
	            				<h2 class="text-center">Profile </h2>
                            </div>
                            <div class="col-md-12">
							    <div class="card mb-0 text-center">
							        <?php echo $__env->make('profile_image_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo $__env->make('social_media_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
	            	<div class="card-body p-0">
	            		<div class="col-md-9">
	            		    <?php echo $__env->make('profile_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            		</div>
	            	</div>
	            </div>

	<script src="<?= JS_URL?>jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="<?= CSS_URL?>jquery.fancybox.min.css" />
    <script src="<?= JS_URL.'confirm_button.js'?>"></script>
</body>
</html>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    method_type='/'+$('#user_id').val()+'/update'
</script>


<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/profile.blade.php ENDPATH**/ ?>