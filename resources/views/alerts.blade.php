<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
include_once(INCLUDES.'minimal_header.php');
include_once(INCLUDES.'sidebar.php');
?>
<div class="col-sm-12 offset-sm-0 py-4">
        <div class="d-flex flex-column " id="content-wrapper">
            <div id="content">
                <div class="container-fluid ">
                    <div class="col-12 p-0">
                        <div class="d-flex flex-column" >
                            <h1 class="alert-primary text-center ">Alerts center</h1>
                        </div>
                    </div>
                    <?php if (isset($alerts) &&!$alerts->isEmpty()): ?>
                        <?php foreach ($alerts  as $key => $alert): ?>
                            @include('alert_body')
                        <?php endforeach ?>
                    <?php else: ?>
                    <h1>
                        @include('no_alerts')
                    </h1>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

<?= (isset($alerts) && !$alerts->isEmpty())?$alerts->links():''?>
<input type="hidden" id="ajaxurl" class="alerts" value="<?= route('user.alerts')?>">
<?php include_once(INCLUDES.'minimal_footer.php');?>
<?php include_once ( INCLUDES . 'footer.php') ?>
<script type="text/javascript" src="{{JS_URL.'notification.js'}}"></script>

@include('footer_script')



