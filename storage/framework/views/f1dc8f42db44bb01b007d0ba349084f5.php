<?php
echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
$logged_username=(isset($logged_username)&&!empty($logged_username))?'for '. $logged_username:'';
?>
   <div class="d-flex flex-column " id="content-wrapper">
        <div id="content">
            <div class="container-fluid ">
                <div class="col-12 p-0">
                    <div class="d-flex flex-column" >
                        <h1 class="alert-primary text-center ">Activity log <?= $logged_username ?></h1>
                    </div>
                </div>
                <?php if (isset($logs)&& !$logs->isEmpty()): ?>
                        <?php foreach ($logs  as $key => $log): ?>
                            <?php echo $__env->make('activitylog_body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach ?>
                <?php else: ?>
                    <?php echo $__env->make('no_logs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif ?>
            </div>
        </div>
    </div>

<?= (isset($logs)&& !$logs->isEmpty())?$logs->links():''?>
<input type="hidden" id="ajaxurl" class="activity_logs" value="<?= route('user.activitylog').'/'?>">
<script type="text/javascript" src="<?php echo e(JS_URL.'notification.js'); ?>"></script>

<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/activitylog.blade.php ENDPATH**/ ?>