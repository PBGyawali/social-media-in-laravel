<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('minimal_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <link rel="stylesheet" href="<?= CSS_URL?>aboutus.css">
<link rel="stylesheet" href="<?= CSS_URL?>animate.css">
</head>
<body>
<div class="container-fluid">
<!-- Main Navigation -->
<nav class="main-nav text-center ">
	<ul>
	<li><a href="#main" class="active link">Our Vision</a></li>
	<li><a href="#about" class="link">About us</a></li>
	<li><a href="#contact" class="link">Get in touch</a></li>
	</ul>
</nav>
<!-- Slider Controls -->
<a href="" id="arrow_left"><img src="<?= ICONS_URL?>arrow-left.png" alt="Slide Left" /></a>
<a href="" id="arrow_right"><img src="<?= ICONS_URL?>arrow-right.png" alt="Slide Right" /></a>

<!-- Home Page -->
<section class="content animated zoomIn" id="main_container">
    <h1>Welcome</h1>
    <h5>Our new site is coming soon!</h5>
    <p >Please keep on reading and keep on posting to support our website.
    The post can be both video or text.</p>
    <a class="link" href="">More info </a>
</section>

<!-- About Page -->
<section class="content animated zoomIn" id="about_container" style="display:none">
    <h1>About</h1>
    <h5>Here's a little about what we're up to.</h5>
    <p>We are striving to be the most visited blog/website for stories, confessions and experience sharing.
    We are working on some project that will make us achieve this goal.</p>
    <p><a href="" class="link">Follow our updates on Twitter</a></p>
</section>



<!-- Contact Page -->
<section class="content animated zoomIn" id="contact_container" style="display:none">
    <div class="">
        <h1>Get in touch</h1>
        <h5>You can get connected to us in the following ways</h5>
        <p>Email: <a class="link" href="mailto:<?= $info->owner_email;?>"><?= $info->owner_email;?></a></p>
        Phone: 0<?= $info->owner_contact_no;?></p>
        Postal address: &nbsp <?= $info->owner_address?>
        <p style="margin:0 0 0 110px;"><?= $info->owner_postal_code;?><br />
        <?= $info->owner_country;?></p>
    </div>

    <!-- Social Links -->
    <nav class="social-nav text-center"  >
        <ul>
        <li><a href="https://www.fb.com/prkhr.pskr"><img src="<?= ICONS_URL?>facebook.png" /></a></li>
        <li><a href=""><img src="<?= ICONS_URL?>twitter.png" /></a></li>
        <li><a href=""><img src="<?= ICONS_URL?>google.png" /></a></li>
        <li><a href=""><img src="<?= ICONS_URL?>dribbble.png" /></a></li>
        <li><a href="https://www.linkedin.com/in/prakhar-gyawali-60a687137/"><img src="<?= ICONS_URL?>linkedin.png" /></a></li>
        <li><a href=""><img src="<?= ICONS_URL?>pinterest.png" /></a></li>
        </ul>
    </nav>
</section>

</div>
<!-- Background Slides -->
<div id="maximage">
    <div>
        <img class="img-fluid"src="<?= BACKGROUNDS_URL?>bg-img-1.jpg" alt="" />
        <img class="gradient img-fluid" src="<?= BACKGROUNDS_URL?>gradient.png" alt="" />
    </div>
    <div>
        <img class="img-fluid"src="<?= BACKGROUNDS_URL?>bg-img-2.jpg" alt="" />
        <img class="gradient img-fluid" src="<?= BACKGROUNDS_URL?>gradient.png" alt="" />
    </div>
    <div>
        <img class="img-fluid" src="<?= BACKGROUNDS_URL?>bg-img-3.jpg" alt="" />
        <img class="gradient img-fluid" src="<?= BACKGROUNDS_URL?>gradient.png" alt="" />
    </div>
    <div>
        <img class="img-fluid" src="<?= BACKGROUNDS_URL?>bg-img-4.jpg" alt="" />
        <img class="gradient img-fluid" src="<?= BACKGROUNDS_URL?>gradient.png" alt="" />
    </div>
    <div>
        <img class="img-fluid"src="<?= BACKGROUNDS_URL?>bg-img-5.jpg" alt="" />
        <img class="gradient  img-fluid" src="<?= BACKGROUNDS_URL?>gradient.png" alt="" />
    </div>
</div>

    <?php echo $__env->make('minimal_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js'></script>
<script src="<?= JS_URL?>jquery.cycle.all.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= JS_URL?>jquery.maximage.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= JS_URL?>main.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">

$(function(){
	$('#maximage').maximage({
		cycleOptions: {
		fx: 'fade',
		speed: 1000, // Has to match the speed for CSS transitions in about.css (lines 48 - 71)
		timeout: 5000,
		prev: '#arrow_left',
		next: '#arrow_right',
		pause: 0,
		before: function(last,current){
			if(!$.browser.msie){
				// Start HTML5 video when you arrive
				if($(current).find('video').length > 0) $(current).find('video')[0].play();
			}
		},
			after: function(last,current){
				if(!$.browser.msie){
					// Pauses HTML5 video when you leave it
					if($(last).find('video').length > 0) $(last).find('video')[0].pause();
				}
			}
		},
		onFirstImageLoaded: function(){
			$('#maximage').fadeIn('fast');
			}
	});
	// Helper function to Fill and Center the HTML5 Video
	$('video,object').maximage('maxcover');
});
</script>
<script type="text/javascript" src="<?= JS_URL.'parsley.min.js'?>"></script>
<?php include_once ( INCLUDES .'footer.php') ?>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/about.blade.php ENDPATH**/ ?>