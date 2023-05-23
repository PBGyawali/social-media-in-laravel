@include('config')
@include('admin_header')
@include('admin_sidebar')
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
<?= (isset($alerts) && !empty($alerts))?$alerts->links():''?>
<input type="hidden" id="ajaxurl" class="alerts" value="<?= route('user.alerts')?>">
<script type="text/javascript" src="{{JS_URL.'notification.js'}}"></script>
@include('footer_script')
