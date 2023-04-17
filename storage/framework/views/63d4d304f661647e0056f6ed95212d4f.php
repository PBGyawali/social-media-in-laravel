<?php
echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(INCLUDES.'minimal_header.php');
include_once(INCLUDES.'sidebar.php');
?>
	<body id="page-top">
	        <div class="col-sm-12 col-md-12 col-xl-12 py-4 ">
			<div class="container container-fluid dashboard ">
	            <div class="row ">
                <div class="col-md-12">
                <a href="<?= route('user.profile')?>"><h1 >Welcome 	<strong style="color: green";><?=$username ?></strong>	    </h1></a>
                </div >
                </div>
                <h3 >Here are some stats for your profile:</h3><br>
                 <div class="row ">
                <?php if ($progresspoints!=100):?>
                <div class="profile_complete_status ">
                    <hr><p class="col-md-12 col-xl-12 mb-4 ">
                    Following is the completeness level of your profile. Please complete all your details to make the progress bar reach
                    100%. Once the progress bar reaches 100%, it will automatically disappear. </p>
                    <hr>
                    <div class="col-md-12 col-xl-12 mb-4">
                        <?php echo $__env->make('progressbar',['heading'=>'Profile Complete progress','value'=>$progresspoints], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                        <?php endif ?>
				<div class="col-md-6 col-xl-3 mb-4">
                    <?php echo $__env->make('small-card',['title'=>'Your Published Post','value'=>$UserPublishedPosts,'icon'=>'blog'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Your Unpublished Posts','value'=>$UserUnpublishedPosts,'icon'=>'question-circle','class'=>'danger'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Total post visitors','value'=>$totalpostviews,'icon'=>'user'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="col-md-6 col-xl-3 mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Follow Requests','value'=>$follow_requests,'icon'=>'comments','class'=>'info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                		<div class="row">
	            	<div class="col-sm-4">
                        <?php echo $__env->make('medium-card',['title' => 'Your Published Posts','value' => $UserPublishedPosts,'class'=>'info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            	<div class="col-sm-4">
                        <?php echo $__env->make('medium-card',['title' => 'Your Unpublished Post','value' => $UserUnpublishedPosts,'class'=>'warning'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            	<div class="col-sm-4">
                        <?php echo $__env->make('medium-card',['title' => 'Total follow reqeusts','value' => $follow_requests,'class'=>'danger'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
				</div>
			</div>
			<div class="row ">
			<div class="col-lg-7 col-xl-8">
                <?php echo $__env->make('chart',['element'=>'post','month'=>$month,'fullmonth'=>$fullmonth,'single_value'=>$monthvalue,'full_value'=>$fullmonthvalue], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
                    <div class="col-lg-5 col-xl-4">
                        <?php echo $__env->make('pie',['title'=>'Visitor Sources','count'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>


			<?php echo $__env->make('footer_top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
	</div>
</body>
</html>
    <?php echo $__env->make('minimal_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript" src= "<?= JS_URL.'progressbar_bootstrap.js'?>"></script>
<script type="text/javascript" src="<?= JS_URL?>chart.min.js"></script>
<script type="text/javascript" src="<?= JS_URL?>graph.js"></script>
<?php include_once(INCLUDES. 'footer.php') ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/dashboard.blade.php ENDPATH**/ ?>