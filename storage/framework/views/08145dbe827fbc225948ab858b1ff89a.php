<div class="card shadow border-left-info py-2">
    <div class="card-body">
        <div class="row align-items-center no-gutters">
            <div class="col mr-2">
                <div class="text-uppercase text-info font-weight-bold text-sm mb-1"><span><?php echo e($heading??'Your Progress'); ?> </span></div>
                <div class="row no-gutters align-items-center">
                    <div class="col value-indicator">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" id ="progressbar_<?php echo e($count??1); ?>" aria-valuenow="<?php echo e($value??5); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($value??5); ?>%;">
                                <span class="sr-only"><?php echo e($value??5); ?>%</span>
                            </div>
                        </div>
                    </div>'
                    <div class="col-auto value-indicator-text">
                        <div class="text-dark text-right font-weight-bold h5 mb-0 ml-3">
                            <span class="progress-value"><?php echo e($value??5); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto"><i class="fas fa-clipboard-list fa-2x"></i></div>
        </div>
    </div>
</div><?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/progressbar.blade.php ENDPATH**/ ?>