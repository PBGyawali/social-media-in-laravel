<li class="dropdown mx-1" role="presentation">
    <div class=" dropdown ">
        <a class="dropdown positon-relative cursor-pointer" data-toggle="dropdown" aria-expanded="false">
            <span id="alertcount"  class="badge <?= $alertcount>0?'badge-danger':"";?> badge-counter position-absolute py-0 pr-1 mr-2" style="top:0;right:0;" >
            <?= (($alertcount>0)?$alertcount:"").(($alertcount>=4)?"+":"") ;?></span>
            <i class="fas fa-bell fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-list animated grow-in pb-0" role="menu">
            <h6 class="dropdown-header alert-primary text-center">alerts center</h6>
            <?php if (isset($alerts) &&!$alerts->isEmpty()): ?>
                <?php foreach ($alerts as $key => $alert): ?>
                    <a class="d-flex align-items-center dropdown-item cursor-pointer whitespace-normal">
                        <div class="mr-3">
                            <div class="icon-circle d-none d-sm-inline-block">
                                <i class="fa fa-<?= $alert->icon_class?>"></i>
                            </div>
                        </div>
                        <div>
                            <span class="small text-gray-500"><?= $alert['alert_date']; ?></span>
                            <p class="d-block text-truncate pb-0 mb-0 col-4 col-sm-8 col-md-12" 
                            style="max-width: 450px;"><?= __('alert.'.$alert->type,['name'=>$alert->alert_name,'value'=>$alert->alert_value]) ?></p>
                        </div>
                    </a>
                <?php endforeach ?>
                <a class="text-center dropdown-item small text-gray-500" href="<?=route($side.'alerts')?>">Show All Alerts</a>
            <?php else: ?>
                <?php include(COMPONENTS.'no_alerts.blade.php')?>
            <?php endif ?>
        </div>
    </div>
</li>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/alert_notification.blade.php ENDPATH**/ ?>