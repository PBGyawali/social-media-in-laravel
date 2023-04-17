<div class="row">
    <div class="col-12 col-md-4">
        <h3 class="card-title"><?php echo e(ucwords(($element.' '.($name??'List')))); ?></h3>
    </div>
    <div class="col-5 col-md-3">
        <div class="row input-daterange">
            <?php if(empty($noreport) && empty($nofilter)): ?>
            <div class="col-6 px-sm-0">
                <input type="date" name="from_date" id="from_date" class="form-control form-control-sm" placeholder="From Date" />
            </div>
            <div class="col-6 px-sm-0">
                <input type="date" name="to_date" id="to_date" class="form-control form-control-sm" placeholder="To Date" />
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-3 col-md-2 px-sm-0 text-center">
        <?php if(empty($noreport) && empty($nofilter)): ?>
        <button type="button"  title="filter by date" id="filter" class="btn btn-info btn-sm pl-sm-1"><i class="fas fa-filter"></i></button>
        <?php endif; ?>
        <?php if(empty($norefresh)): ?>
            <button type="button"  title="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
        <?php endif; ?>
        <?php if(isset($reporturl)): ?>
            <button type="button" id="report" title="Get Report" data-url="<?php echo e($reporturl); ?>"data-table="<?php echo e($table??$element); ?>"class="btn btn-info btn-sm"><i class="fas fa-print"></i></button>
        <?php endif; ?>
        <?php if(isset($exporturl)): ?>
            <button type="button" id="export" data-url="<?php echo e($exporturl); ?>"  class="text-success btn btn-sm p-0"><i class="fas fa-file-csv fa-2x"></i></button>
        <?php endif; ?>
    </div>
    <div class="col-4 col-md-3  text-right">
        <?php if(empty($nobutton)): ?>
            <?php if(isset($fake)): ?>
                <button type="button" id="fake_button" data-element="<?php echo e(ucwords($element.' '.($extratext??''))); ?>" data-toggle="modal" data-target="#Modal" class="btn btn-primary rounded btn-sm ">
                    <i class="fas fa-robot""></i> Fake
                </button>
            <?php endif; ?>
            <button type="button" name="add" id="add_button" data-element="<?php echo e(ucwords($element.' '.($extratext??''))); ?>" data-toggle="modal" data-target="#Modal" class="btn btn-success btn-sm">
                <i class="fas fa-<?php echo e($buttonicon??'plus'); ?>"></i> Add
            </button>
        <?php endif; ?>

    </div>
</div>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/header_card.blade.php ENDPATH**/ ?>