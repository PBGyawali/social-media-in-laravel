@include('config')
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
							        @include('profile_image_card')
                                </div>
                            </div>
                        </div>
                        @include('social_media_buttons')
                    </div>
	            	<div class="card-body p-0">
	            		<div class="col-md-9">
	            		    @include('profile_form')
	            		</div>
	            	</div>
	            </div>

	<script src="<?= JS_URL?>jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="<?= CSS_URL?>jquery.fancybox.min.css" />
    <script src="<?= JS_URL.'confirm_button.js'?>"></script>
</body>
</html>
@include('footer_script')
<script>
    method_type='/'+$('#user_id').val()+'/update'
</script>


