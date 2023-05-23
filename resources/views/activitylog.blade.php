@include('config')
@include('minimal_header')
@include('sidebar');
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
@include('minimal_footer')
@include('footer')
<input type="hidden" id="ajaxurl" class="activity_logs" value="<?= route('user.activitylog').'/'?>">
<script type="text/javascript" src="{{JS_URL.'notification.js'}}"></script>

@include('footer_script')
