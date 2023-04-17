<div class="row <?=$log->type;?>">
    <div class="col-lg-12 col-xl-12 col-sm-12">
        <div class="card shadow mb-1">
            <div class="card-header d-flex text-center justify-content-between align-items-center">
                <h6 class="text-primary font-weight-bold m-0 ">
                    <a class="d-flex align-items-center dropdown-item " >
                        <div class="mr-3">
                            <div class="icon-circle "><i class="fa fa-<?= $log->icon_class?>"></i></div>
                        </div>
                            <?php $parent=$log->parent_activity_text;?>
                        <div>
                            <span class="small text-gray-500"><?= $log['activity_performed']; ?></span>
                            <p>
                            {!! __('log.'.$log->activity_object.'.'.$log->type,['name'=>$log->parent_activity_text,'value'=>$log->parent_activity_text]) !!}
                        </p>
                        </div>
                    </a>
                </h6>
                <div class="dropdown no-arrow">
                    <button class="btn btn-link btn-sm" data-toggle="dropdown" aria-expanded="false" type="button">
                        <i class="fas fa-ellipsis-v text-blue-400"></i></button>
                    <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                        <p class="text-center dropdown-header m-0 p-0">Action:</p>
                        <a class="dropdown-item pt-0 logaction" role="presentation" data-method_type="delete" data-action="delete" data-type="<?=$log->type;?>" data-id="<?= $log->id; ?>" >Delete this</a>
                        <a class="dropdown-item pt-0 logaction" role="presentation" data-method_type="delete" data-action="delete_similar" data-type="<?=$log->type;?>" data-id="<?= $log->user_id; ?>" >Clean related logs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
