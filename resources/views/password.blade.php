@include('config')
    @include('minimal_header')
        @include('sidebar')
<link rel="stylesheet" type="text/css" href="<?=  CSS_URL.'profile.css' ?>">
<style>body {background-image: url('<?=BACKGROUNDS_URL?>contactusbg.jpg');}</style>
</head>
<body >
<img src="<?= $info->website_logo; ?>"class="d-block mx-auto img-responsive " width="120" height= "120">
	        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-6 pt-3 m-auto">
			<div class="row row-fluid">
			<span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>
				</div>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
	            				<h2>Change Password <i class="fas fa5x fa-lock"></i></h2>
	            			</div>

	            		</div>
	            	</div>
	            	@include('password_change_form')

			</div>

		</div>

	</div>

</body>
</html>
@include('minimal_footer')
<script src="<?= JS_URL.'confirm_button.js'?>"></script>
@include('footer_script')
<script>var method_type='/'+$('#changer_id').val();</script>
