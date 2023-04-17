
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="test"></h6><!--needs to be kept as an element unless new element is added for css reasons-->
            <h6 class="text-primary font-weight-bold m-0"><span class="label" id="label_<?php echo e($count??0); ?>"><?php echo e(ucwords($element??'purchase')); ?></span> Overview (By <span id="type_<?php echo e($count??0); ?>"><?php echo e($unit??'number'); ?></span>)</h6>
            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v "></i></button>
                <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"	role="menu">
                    <p class="text-center dropdown-header">Action:</p>
                    <?php if(isset($single_value)): ?>
                        <a role="presentation" id="permonth_<?php echo e($count??0); ?>"  class="dropdown-item permonth"     data-id="<?php echo e($count??0); ?>" data-month='[<?php echo $month;?>]' data-monthvalue='[<?php echo $single_value;?>]' style="display:none"> Show only available <?php echo e(ucwords($element??'purchase')); ?> data</a>
                    <?php endif; ?>
                    <?php if(isset($full_value)): ?>
                        <a role="presentation" id="fullmonths_<?php echo e($count??0); ?>" class="dropdown-item fullmonths"  data-id="<?php echo e($count??0); ?>" data-month='[<?php echo $fullmonth;?>]' data-monthvalue='[<?php echo $full_value;?>]'> Show all <?php echo e(ucwords($element??'purchase')); ?> data</a>
                    <?php endif; ?>
                    <?php if(isset($refreshurl)): ?>
                        <a role="presentation" id="refresh_<?php echo e($count??0); ?>" class="dropdown-item refresh"        data-id="<?php echo e($count??0); ?>" data-url="<?php echo e($refreshurl); ?>" > Refresh</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a role="presentation" id="bargraph_<?php echo e($count??0); ?>" class="dropdown-item bargraph" 	 data-id="<?php echo e($count??0); ?>" data-chart='<?php echo e($type??'line'); ?>' data-type="permonth" > Show <span id="showtype_<?php echo e($count??0); ?>"><?php echo e(isset($type)?'line':'bar'); ?></span> graphs</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" >
                <canvas id="graph_canvas_<?php echo e($count??0); ?>"
                    data-bs-chart="{
                        &quot;type&quot;:&quot;<?php echo e($type??'line'); ?>&quot;,
                        &quot;data&quot;:{
                            &quot;labels&quot;:[<?php echo $month?>],
                            &quot;datasets&quot;:[{
                                &quot;data&quot;:[<?php echo $single_value?>],
                                &quot;label&quot;:&quot;<?php echo e(ucwords($element??'purchase')); ?>&quot;,
                                &quot;fill&quot;:true,
                                &quot;backgroundColor&quot;:&quot;rgba(255, 99, 132)&quot;,
                                &quot;borderColor&quot;:&quot;#444444&quot;
                            }]
                        },
                        &quot;options&quot;:{
                            &quot;responsive&quot;:true,
                            &quot;maintainAspectRatio&quot;:false,
                            &quot;legend&quot;:{&quot;display&quot;:false},
                            &quot;title&quot;:{},
                            &quot;scales&quot;:{
                                &quot;xAxes&quot;:[{
                                    &quot;gridLines&quot;:{
                                        &quot;color&quot;:&quot;rgb(24, 236, 244)&quot;,
                                        &quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,
                                        &quot;drawBorder&quot;:false,
                                        &quot;drawTicks&quot;:false,
                                        &quot;borderDash&quot;:[&quot;2&quot;],
                                        &quot;zeroLineBorderDash&quot;:[&quot;2&quot;],
                                        &quot;drawOnChartArea&quot;:false
                                    },
                                    &quot;ticks&quot;:{
                                        &quot;fontColor&quot;:&quot;#858796&quot;,
                                        &quot;padding&quot;:20
                                    }
                                }],
                                &quot;yAxes&quot;:[{
                                            &quot;gridLines&quot;:{
                                                &quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,
                                                &quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,
                                                &quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,
                                                &quot;borderDash&quot;:[&quot;2&quot;],
                                                &quot;zeroLineBorderDash&quot;:[&quot;2&quot;]
                                            },
                                            &quot;ticks&quot;:{
                                                &quot;fontColor&quot;:&quot;#858796&quot;,
                                                &quot;padding&quot;:20
                                            }
                                }]
                            }
                        }
                    }"
                >
                </canvas>
            </div>
        </div>
    </div>







<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/chart.blade.php ENDPATH**/ ?>