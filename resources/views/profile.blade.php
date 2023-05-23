@include('config')
 @include('minimal_header')
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
                                    @include('profile_image_card')
                                </div>
                            </div>
                        </div>
							    @include('social_media_buttons')
	            	</div>
	            	<div class="card-body p-0 pb-2">
	            		<div class="col-md-12">
	            			@include('profile_form')
	            		</div>
	            	</div>
	            </div>
	        </div>




@include('minimal_footer')
@include('footer')
	<script src="<?= JS_URL?>jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="<?= CSS_URL?>jquery.fancybox.min.css" />
	<script src="<?= JS_URL.'confirm_button.js'?>"></script>

</body>
</html>
@include('footer_script')
