<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


			<div class="container container-fluid dashboard ml-0 pl-0 ">
				<a href="<?= route('profile')?>">
                    <h1 >Welcome <?= auth()->user()->username ?></strong></h1>
                </a>
                <h3 class="d-flex justify-content-between align-items-center">
                    Here are some stats for <?= $info->website_name?>:</h3><br>
                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                            <form action="" method="post">
                                    <button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" formaction="http://localhost/us_opt1/index.php?route=/database/structure&db=social_media" formtarget="_blank">
                                        <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Administrate Database
                                    </button>
                                </form>
                <button class="btn btn-primary btn-sm d-none d-sm-inline-block" 
                    role="button" href="#" formtarget="_blank">
                    <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
                </button>
                </div>
                <div class="row ">
                    <div class="col-12 mb-0">
                            <h3 >Stats for <strong style="color: green";><?= $username ?></strong>:</h3>
                    </div>
                </div>

                <div class="row ">
                    <div class="col mb-4">
                        <?php echo $__env->make('progressbar',['heading'=>'Profile Complete progress','value'=>$progresspoints], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
				    <div class="col mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Total Published Post','value'=>$UserPublishedPosts,'icon'=>'blog'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Total post visitors','value'=>$totalpostviews,'icon'=>'user'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Total Followers','value'=>$follow_requests,'icon'=>'comments','class'=>'warning'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="row ">
                    <div class="col mb-0">
                        <h3 >Stats for <?= $info->website_name?>:</h3>
                    </div>
                </div>

	            <div class="row ">
                    <div class="col mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Total Registered Users','value'=>$AllUsers,'icon'=>'users'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <div class="col mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Unverified Account (Email)','value'=>$UnverifiedEmail,'icon'=>'question','class'=>'danger'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col mb-4">
                        <?php echo $__env->make('small-card',['title'=>'Unverified Account (profile)','value'=>$UnverifiedProfile,'icon'=>'calendar','class'=>'dark'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col mb-4">
                        <?php echo $__env->make('progressbar',['heading'=>'Total User Target','value'=>$target], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
						<div class="row">
	            	<div class="col">
                        <?php echo $__env->make('medium-card',['title' => 'Published Posts','value' => $AllPublishedPosts,'link' => 'posts','class'=>'info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            	<div class="col">
                        <?php echo $__env->make('medium-card',['title' => 'Unpublished Post','value' => $AllUnpublishedPosts,'link' => 'posts','class'=>'warning'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            	<div class="col">
                        <?php echo $__env->make('medium-card',['title' => 'Unresolved Tickets','value' => $AllUnresolvedTickets,'link' => 'tickets','class'=>'danger'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	</div>
	            	<div class="col">
                        <?php echo $__env->make('medium-card',['title' => 'Website Visitors','value' => $AllVisitCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<!--from here starts the new div-->
					</div>
				</div>
			</div>
            <div class="row ">
                <div class="col-lg-7 col-xl-8">
                    <?php echo $__env->make('chart',['type'=>'bar','element'=>'post','refreshurl'=>route('admin.dashboard.edit'),'month'=>$month,'fullmonth'=>$fullmonth,'single_value'=>$monthvalue,'full_value'=>$fullmonthvalue], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                    <div class="col-lg-5 col-xl-4">
                        <?php echo $__env->make('pie',['title'=>'Visitor Sources','category'=>$visitor_sources,'value'=>$visitor_sources_count,'type'=>'pie','count'=>1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			</div>
			<?php echo $__env->make('footer_top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>'
	</div>
</body>
</html>
<script src= "<?= JS_URL .'progressbar_bootstrap.js'?>"></script>
<script type="text/javascript" src="<?= JS_URL?>chart.min.js"></script>
<script type="text/javascript" src="<?= JS_URL?>jquery.easing.min.js"></script>
<script type="text/javascript" src="<?= JS_URL?>graph.js"></script>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/index.blade.php ENDPATH**/ ?>