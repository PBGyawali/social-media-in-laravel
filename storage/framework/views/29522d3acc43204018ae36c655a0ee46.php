<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php echo $__env->make('minimal_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
	$sex=$user->sex;$facebook= $user->facebook;$twitter=$user->twitter;
	$googleplus=$user->googleplus;$firstname=$user->first_name;$lastname= $user->last_name;
$username=$check->username;
$profileimage=$check->profile_image;
$email=$check->email;
?>
<style>body {background-image: url('<?=BACKGROUNDS_URL?>contactusbg.jpg');padding:0}</style>
</head>
<body>
            <img src="<?= $info->website_logo; ?>"class="d-block mx-auto img-responsive " width="120" height= "120">
	        <div class="col-xs-12 col-sm-9 col-md-5 col-lg-4 px-0 pb-2 mx-auto mb-4">
			    <span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>
			    <div class="card mt-0">
	            	<div class="card-header md-3 p-0 no-border">
	            		<div class="row mb-0">
	            			<div class="col-12 text-center">
	            				<h2 class="text-center m-0">Profile</h2>
                            </div>
							<div class="col-md-12">
                                <div class="card mb-0 text-center">
                                    <?php echo $__env->make('profile_image_card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </div>
                            </div>
                        </div>
							    <?php echo $__env->make('social_media_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            	<div class="card-body p-0 pb-2">
	            		<div class="col-md-12">
	            			<?php echo $__env->make('profile_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            		</div>
	            	</div>
	            </div>
	        </div>




<?php echo $__env->make('minimal_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php include_once(INCLUDES. 'footer.php') ?>
	<script src="<?= JS_URL?>jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="<?= CSS_URL?>jquery.fancybox.min.css" />
	<script src="<?= JS_URL.'confirm_button.js'?>"></script>

</body>
</html>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    method_type='/'+$('#user_id').val()+'/update'
</script>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/profile.blade.php ENDPATH**/ ?>