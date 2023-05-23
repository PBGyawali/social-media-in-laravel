
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="test"></h6><!--needs to be kept as an element unless new element is added for css reasons-->
            <h6 class="text-primary font-weight-bold m-0">
                    <span class="label" id="label_{{$count??0}}">{{ucwords($element??'purchase')}}</span> Overview (By <span id="type_{{$count??0}}">{{$unit??'number'}}</span>)</h6>
            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v "></i></button>
                <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"	role="menu">
                    <p class="text-center dropdown-header">Action:</p>
                    @isset($single_value)
                        <a role="presentation" id="permonth_{{$count??0}}"  class="dropdown-item permonth"     data-id="{{$count??0}}" data-month='[<?php echo $month;?>]' data-monthvalue='[<?php echo $single_value;?>]' style="display:none"> Show only available {{ucwords($element??'purchase')}} data</a>
                    @endisset
                    @isset($full_value)
                        <a role="presentation" id="fullmonths_{{$count??0}}" class="dropdown-item fullmonths"  data-id="{{$count??0}}" data-month='[<?php echo $fullmonth;?>]' data-monthvalue='[<?php echo $full_value;?>]'> Show all {{ucwords($element??'purchase')}} data</a>
                    @endisset
                    @isset($refreshurl)
                        <a role="presentation" id="refresh_{{$count??0}}" class="dropdown-item refresh"        data-id="{{$count??0}}" data-url="{{$refreshurl}}" > Refresh</a>
                    @endisset
                    <div class="dropdown-divider"></div>
                    <a role="presentation" id="bargraph_{{$count??0}}" class="dropdown-item bargraph" 	 data-id="{{$count??0}}" data-chart='{{$type??'line'}}' data-type="permonth" > Show <span id="showtype_{{$count??0}}">{{isset($type)?'line':'bar'}}</span> graphs</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" >
                <canvas id="graph_canvas_{{$count??0}}"
                    data-bs-chart="{
                        &quot;type&quot;:&quot;{{$type??'line'}}&quot;,
                        &quot;data&quot;:{
                            &quot;labels&quot;:[<?php echo $month?>],
                            &quot;datasets&quot;:[{
                                &quot;data&quot;:[<?php echo $single_value?>],
                                &quot;label&quot;:&quot;{{ucwords($element??'purchase')}}&quot;,
                                &quot;fill&quot;:true,
                                &quot;backgroundColor&quot;:&quot;rgba(255, 99, 132)&quot;,
                                &quot;borderColor&quot;:&quot;#444444&quot;,
                                &quot;hoverBackgroundColor&quot;: &quot;#555555&quot;,
                                &quot;hoverBorderColor&quot;:&quot;#0047AB&quot;,
                                &quot;borderWidth&quot;: 3
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
                                         {{-- draws horizontal line in x axis --}}
                                        &quot;drawBorder&quot;:false,
                                        &quot;drawTicks&quot;:false,
                                        &quot;borderDash&quot;:[&quot;2&quot;],
                                        &quot;zeroLineBorderDash&quot;:[&quot;2&quot;],
                                        {{-- draws vertical line as divider between data --}}
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
                                                &quot;padding&quot;:20,
                                                {{-- min for bargraph --}}
                                                &quot;min&quot;:0
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



