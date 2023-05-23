<div class="row <?= $alert->type; ?>" id="alert_header_<?= $alert->id; ?>">
    <div class="col-lg-12 col-xl-12 col-sm-12">
        <div class="card shadow mb-1" id="alert_<?= $alert->id; ?>">
            <div class="card-header d-flex text-center justify-content-between align-items-center">
                <h6 class="text-primary font-weight-bold m-0 ">
                    <a class="d-flex align-items-center dropdown-item cursor-pointer whitespace-normal" >
                        <div class="mr-3">
                            <div class="icon-circle d-none d-sm-inline-block"><i class="fa fa-<?= $alert->icon_class?>"></i></div>
                        </div>
                        <div>
                            <span class="small text-gray-500"><?= $alert->alert_date; ?></span>
                            <p>
                                <?= __('alert.'.$alert->type,['name'=>$alert->alert_name,'value'=>$alert->alert_value,'title'=>$alert->alert_value])?>
                            </p>
                        </div>
                    </a>
                </h6>
                <div class="dropdown no-arrow">
                    <button class="btn btn-link btn-sm" data-toggle="dropdown" aria-expanded="false" type="button">
                    <i class="fas fa-ellipsis-v text-blue-400"></i></button>
                    <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                        <p class="text-center dropdown-header m-0 p-0">Action:</p>
                        <a class="dropdown-item pt-0 alertaction" role="presentation" data-method_type="/delete" data-action="delete" data-type="<?= $alert->type; ?>" data-id="<?= $alert->id; ?>" style="cursor:pointer">Delete this alert</a>
                        <a class="dropdown-item pt-0 alertaction" role="presentation" data-method_type="/update" data-action="read" data-type="<?= $alert->type; ?>" data-id="<?= $alert->id; ?>" style="cursor:pointer">Mark as Read</a>
                        <a class="dropdown-item pt-0 alertaction" role="presentation" data-method_type="/delete" data-action="delete_similar" data-type="<?= $alert->type; ?>"data-id="<?= $alert->user_id; ?>" style="cursor:pointer">Delete similar notifications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


