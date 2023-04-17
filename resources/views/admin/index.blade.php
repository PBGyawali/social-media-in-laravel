@include('config')
<?php
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
?>
<body id="page-top">
			<div class="container container-fluid dashboard ml-0 pl-0 ">
				<a href="<?= route('profile')?>">
                    <h1 >Welcome <?= $username ?></strong></h1>
                </a>
<h3 class="d-flex justify-content-between align-items-center">Here are some stats for <?= $website_name?>:</h3><br>
<div class="d-sm-flex justify-content-between align-items-center mb-4">
  <form action="" method="post">
        <button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" formaction="http://localhost/us_opt1/index.php?route=/database/structure&db=social_media" formtarget="_blank">
            <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Administrate Database
        </button>
    </form>
<button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#" formtarget="_blank"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</button>
</div>
                <div class="row ">
                    <div class="col-md-7 col-xl-8 mb-0">
                            <h3 >Stats for <strong style="color: green";><?= $username ?></strong>:</h3>
                    </div>
                </div>

                <div class="row ">
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('progressbar',['heading'=>'Profile Complete progress','value'=>$progresspoints])
                    </div>
				    <div class="col-md-6 col-xl-3 mb-4">
                        @include('small-card',['title'=>'Total Published Post','value'=>$UserPublishedPosts,'icon'=>'blog'])
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('small-card',['title'=>'Total post visitors','value'=>$totalpostviews,'icon'=>'user'])
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('small-card',['title'=>'Total Followers','value'=>$follow_requests,'icon'=>'comments','class'=>'warning'])
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-6 col-xl-8 mb-0">
                        <h3 >Stats for <?= $website_name?>:</h3>
                    </div>
                </div>

	            <div class="row ">
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('small-card',['title'=>'Total Registered Users','value'=>$AllUsers,'icon'=>'users'])
                        </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('small-card',['title'=>'Unverified Account (Email)','value'=>$UnverifiedEmail,'icon'=>'question','class'=>'danger'])
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('small-card',['title'=>'Unverified Account (profile)','value'=>$UnverifiedProfile,'icon'=>'calendar','class'=>'dark'])
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        @include('progressbar',['heading'=>'Total User Target','value'=>$target])
                    </div>
                </div>
						<div class="row">
	            	<div class="col-12 col-sm-6 col-md-3">
                        @include('medium-card',['title' => 'Published Posts','value' => $AllPublishedPosts,'link' => 'posts','class'=>'info'])
	            	</div>
	            	<div class="col-12 col-sm-6 col-md-3">
                        @include('medium-card',['title' => 'Unpublished Post','value' => $AllUnpublishedPosts,'link' => 'posts','class'=>'warning'])
	            	</div>
	            	<div class="col-12 col-sm-6 col-md-3">
                        @include('medium-card',['title' => 'Unresolved Tickets','value' => $AllUnresolvedTickets,'link' => 'tickets','class'=>'danger'])
	            	</div>
	            	<div class="col-12 col-sm-6 col-md-3">
                        @include('medium-card',['title' => 'Website Visitors','value' => $AllVisitCount])
						<!--from here starts the new div-->
					</div>
				</div>
			</div>
            <div class="row ">
                <div class="col-lg-7 col-xl-8">
                    @include('chart',['type'=>'bar','element'=>'post','refreshurl'=>route('admin.dashboard.edit'),'month'=>$month,'fullmonth'=>$fullmonth,'single_value'=>$monthvalue,'full_value'=>$fullmonthvalue])
                </div>
                    <div class="col-lg-5 col-xl-4">
                        @include('pie',['title'=>'Visitor Sources','category'=>$visitor_sources,'value'=>$visitor_sources_count,'type'=>'pie','count'=>1])
				</div>
			</div>
			@include('footer_top')
		</div>'
	</div>
</body>
</html>
<script src= "<?= JS_URL .'progressbar_bootstrap.js'?>"></script>
<script type="text/javascript" src="<?= JS_URL?>chart.min.js"></script>
<script type="text/javascript" src="<?= JS_URL?>jquery.easing.min.js"></script>
<script type="text/javascript" src="<?= JS_URL?>graph.js"></script>
@include('footer_script')
