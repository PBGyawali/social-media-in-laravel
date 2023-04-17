<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
    $check=auth()->user()??'';
?>
<?php echo $__env->make('minimal_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<link rel="stylesheet" type="text/css" href="<?= CSS_URL?>post.css">
<style type="text/css">
body {
    font-family: Arial;
}
</style>
</head>
<body class="pt-0 bg-gray-200 ">
<?php include_once(INCLUDES.'sidebar.php');?>
    <div class="post-wall ">
	<input type="hidden"  id="total_count" value="<?= $count; ?>" />
    <input type="hidden"  id="action_server" value="<?= route('article'); ?>" />
    <input type="hidden"  id="scroll_server" value="<?= route('home'); ?>" />
    <input type="hidden" id="rating_server" value="<?= route('ratings')?>" />
    </div>
<div class="container-fluid mt-3">
	<div class="row mx-0">
		<div class="col-xs-0 col-md-2 mx-0 px-0">
		</div>
		<div class="col-xs-12 col-md-6 offset-md-1 px-0 postwall bg-gray-100 whitespace-normal break-all border-solid border-2 border-t-0 border-b-0 border-yellow-800 rounded-lg" >
            <?php echo $__env->make('moredata', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		    <?php echo $__env->make('minimal_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class=" col-md-2 mx-0 px-0 d-none d-sm-block">
                <?php if($check): ?>
                    <?php echo $__env->make('chatbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
    </div>
    <div class="row mb-2">
		<div class="col-xs-0 col-md-2 mx-0 px-0">
        </div>
        <div class="col-xs-12 col-md-6 offset-md-1 ">
            <div class="ajax-loader d-none text-center mb-2">
                <i class="fa fa-spinner fa-pulse fa-3x text-secondary"></i>
                <h4 class="d-inline"> Loading more posts...</h4>
            </div>
            <div class="finished d-none text-center mb-2">
                <h4>No more posts available...</h4>
            </div>
        </div>
    </div>
</div><!-- container div end -->
<?php include_once (INCLUDES.'footer.php') ?>
<script type="text/javascript" src="<?= JS_URL?>scroll.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>comment_system.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>user_action.js" ></script>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/home.blade.php ENDPATH**/ ?>