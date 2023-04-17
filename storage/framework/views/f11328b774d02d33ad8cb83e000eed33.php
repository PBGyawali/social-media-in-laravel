<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="text-primary font-weight-bold m-0"><?php echo e($title??'No title'); ?></h6>
        <div class="dropdown no-arrow">
            <button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in" role="menu">
                <p class="text-center dropdown-header">Action:</p>
                <?php if(isset($refreshurl)): ?>
                    <a class="dropdown-item" role="presentation" data-id="<?php echo e($count??0); ?>">&nbsp;Refresh</a>
                <?php endif; ?>
                <a class="dropdown-item pie"
                    data-category='[<?php echo $category??'&quot;Chrome&quot;,&quot;Firefox&quot;,&quot;Safari&quot;'; ?>]'
                    data-value='[<?php echo $value??'&quot;55&quot;,&quot;65&quot;,&quot;66&quot;'; ?>]'
                    id="pie_<?php echo e($count??0); ?>"  data-chart='<?php echo e($type??'doughnut'); ?>'
                    data-id="<?php echo e($count??0); ?>" role="presentation">
                    &nbsp;Show <span id="showtype_<?php echo e($count??0); ?>"><?php echo e(isset($type)?'doughnut':'pie'); ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="chart-area" id="piechart_<?php echo e($count??0); ?>">
            <canvas id="graph_canvas_<?php echo e($count??0); ?>"
                data-bs-chart="{
                    &quot;type&quot;:&quot;<?php echo e($type??'doughnut'); ?>&quot;,
                    &quot;data&quot;:{
                        &quot;labels&quot;:[<?php echo $category??'&quot;Chrome&quot;,&quot;Firefox&quot;,&quot;Safari&quot;'; ?>],
                        &quot;datasets&quot;:[{
                            &quot;backgroundColor&quot;:[&quot;rgb(255, 99, 132)&quot;,&quot;rgb(87, 191, 46)&quot;,&quot;rgb(255, 205, 86)&quot;,&quot;#555555&quot;,&quot;#0047AB&quot;,&quot;#444444&quot;],
                            &quot;borderColor&quot;:&quot;#444444&quot;,
                            &quot;data&quot;:[<?php echo $value??'&quot;55&quot;,&quot;65&quot;,&quot;66&quot;'; ?>]
                        }]
                    },
                    &quot;options&quot;:{
                        &quot;maintainAspectRatio&quot;:false,
                        &quot;legend&quot;:{&quot;display&quot;:true},
                        &quot;title&quot;:{}
                    }
                }"
            >
            </canvas>
        </div>
    </div>
</div><!--card siv ends--><?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/pie.blade.php ENDPATH**/ ?>