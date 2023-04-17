<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(INCLUDES.'minimal_header.php');
include_once(INCLUDES.'sidebar.php');
?>
<div class="col py-4">
    <div class="d-flex flex-column " id="content-wrapper">
        <div id="content">
            <div class="container-fluid ">
                <div class="col-12 p-0">
                    <div class="d-flex flex-column" >
                        <h1 class="alert-primary text-center ">Activity log </h1>
                    </div>
                </div>
                <?php if (isset($logs)&& !$logs->isEmpty()): ?>
                    <?php foreach ($logs  as $key => $log): ?>
                      @include('activitylog_body')
                    <?php endforeach ?>
                <?php else: ?>
                    @include('no_logs')
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= (isset($logs)&&!$logs->isEmpty())?$logs->links():'' ?>
<?php include_once(INCLUDES.'minimal_footer.php');?>
<?php include_once ( INCLUDES . 'footer.php') ?>
<input type="hidden" id="ajaxurl" class="activity_logs" value="<?= route('user.activitylog').'/'?>">
<script type="text/javascript" src="{{JS_URL.'notification.js'}}"></script>

@include('footer_script')
