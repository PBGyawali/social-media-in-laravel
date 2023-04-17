<?php
echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();

include_once(ADMIN_INCLUDES.'admin_header.php');
include_once(ADMIN_INCLUDES.'admin_sidebar.php');
$logged_username=(isset($log_username)&&!empty($log_username))?'for '. $log_username:'';
?>
<input type="hidden" name="" id="ajaxurl" class="alerts" value="<?= route('alerts')?>">
<div class="d-flex flex-column " id="content-wrapper">
    <div id="content">
        <div class="container-fluid ">
            <div class="col-12 p-0">
                <div class="d-flex flex-column" >
                    <h1 class="alert-primary text-center ">All alerts <?= $logged_username ?></h1>
                </div>
            </div>
            <?php if (isset($logged_alerts) && !$logged_alerts->isEmpty()): ?>
                <?php foreach ($logged_alerts  as $key => $alert): ?>
                    <?php echo $__env->make('alert_body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach ?>
            <?php else: ?>
            <h1>
                <?php echo $__env->make('no_alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </h1>
            <?php endif ?>
        </div>
    </div>
</div>
<?= (isset($alerts) && !empty($alerts))?$alerts->links():''?>
<input type="hidden" id="ajaxurl" class="alerts" value="<?= route('user.alerts')?>">
<script type="text/javascript" src="<?php echo e(JS_URL.'notification.js'); ?>"></script>
<?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/alerts.blade.php ENDPATH**/ ?>