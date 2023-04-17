$(document).ready(function()
{
	$('[data-bs-chart]').each(function(index, elem) {
		window ['figure_'+index]= new Chart($(elem), $(elem).data('bs-chart'));
	});

    function emptyspace(canvas){
        const context = canvas.getContext('2d');
        // Store the current transformation matrix
            context.save();
            // Use the identity matrix while clearing the canvas
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.clearRect(0, 0, canvas.width, canvas.height);
            // Restore the transform
            context.restore();
            return true;
    }

    $('.bargraph').on('click', function()
    {
        var id=$(this).data('id');
		var type=$(this).data('type');
        let chart=$(this).data('chart');
        let nextchart=chart=='line'?'bar':'line';
        var month=$('#'+type+'_'+id).data('month');
        var monthvalue=$('#'+type+'_'+id).data('monthvalue');
        updateGraph(month,monthvalue,id,nextchart);
        $('#showtype_'+id).html(chart);
        $(this).data('chart',nextchart);
    });

    $('.pie').on('click', function()
    {
        var id=$(this).data('id')
        let chart=$(this).data('chart');
        let nextchart=chart=='pie'?'doughnut':'pie';
        let category=$(this).data('category')
        let value=$(this).data('value')
        updateGraph(category,value,id,nextchart);
        $('#showtype_'+id).html(chart);
        $(this).data('chart',nextchart);
    });

    $('.permonth').on('click', function()
    {   var id=$(this).data('id');
		var month=$(this).data('month');
        var monthvalue=$(this).data('monthvalue');
        let chart=$('#bargraph'+'_'+id).data('chart');
        updateGraph(month,monthvalue,id,chart);
        $('#fullmonths'+'_'+id).show();
        $('#permonth'+'_'+id).hide();
        $('#bargraph'+'_'+id).data('type','permonth');
    });

    $('.fullmonths').on('click', function()
    {   var id=$(this).data('id');
		var month=$(this).data('month');
        var monthvalue=$(this).data('monthvalue');
        let chart=$('#bargraph'+'_'+id).data('chart');
        updateGraph(month,monthvalue,id,chart);
       $('#fullmonths'+'_'+id).hide();
        $('#permonth'+'_'+id).show();
        $('#bargraph'+'_'+id).data('type','fullmonths');
    });



    function updateGraph($category,$value,id=null,$type='line')
    {
	   var label=$('#label_'+id).text()||'progress';
	   var canvas = document.getElementById("graph_canvas_"+id);
       $space= emptyspace(canvas);

	   if (window['figure_'+id].chart!=undefined) {
		window['figure_'+id].chart.destroy();
        }
        let chartOptions=['line','bar'].includes($type)?graphOptions:pieOptions;
        let backgroundColor=['line','bar'].includes($type)?'rgb(255, 99, 132)':['rgb(255, 99, 132)','rgb(87, 191, 46)','rgb(255, 205, 86)','#555555','#0047AB','#444444'];
        if ($space)
        {
            window ['figure_'+id]= new Chart(canvas,
            {
                    type: $type,
                    data: {
                            labels: $category,//labels to compare against
                            datasets:
                            [{
                                    data: $value,
                                    borderWidth: 3,
                                    hoverBackgroundColor: '#555555',
                                    hoverBorderColor:'#0047AB',
                                    label:label,//value to display on hover
                                    fill:true,//for line fill the below area
                                    borderColor:' #444444',
                                    backgroundColor:backgroundColor
                            }]
                        },
                    options:  chartOptions
            });
        }
    }

    $('.refresh').on('click', function()
    { 	var id=$(this).data('id');
		var url=$(this).data('url');
		var table=$('#label_'+id).text().toLowerCase();
		var type=$('#type_'+id).text().toLowerCase();
        let chart=$('#bargraph'+'_'+id).data('chart');
      $.ajax
      ({
            url: url,
            method: 'post',
            data:  {get_full_data:1,table:table,type:type},
           dataType:"JSON",
            success: function(data)
            {
                updateGraph(data.labels,data.data,id,chart);
            }
        });
    });




        const graphOptions={
            responsive: true,
            maintainAspectRatio:false,
            legend:
            {
                display: false
            },
            title:{},
            scales:
            {
                xAxes:
                [{
                    gridLines:
                    {
                        color:'rgb(234, 236, 244)',
                        zeroLineColor:'rgb(234, 236, 244)',
                        drawBorder:false,
                        drawTicks:false,
                        borderDash:[2],
                        zeroLineBorderDash:[2],
                        drawOnChartArea:false
                    },
                    ticks:
                    {
                        fontColor:'#858796',
                        padding:20
                    }
                }],
                yAxes:
                [{
                    gridLines:
                    {   color:'rgb(234, 236, 244)',
                        zeroLineColor:'rgb(234, 236, 244)',
                        drawBorder:false,
                        drawTicks:false,
                        borderDash:[2],
                        zeroLineBorderDash:[2]
                    },
                    ticks:
                    {
                        fontColor:'#858796',
                        padding:20
                    }
                }]
            }
        }

            const pieOptions={
                responsive: true,
                maintainAspectRatio:false,
                legend:{display:true},
                title:{},
                animation:{
                    animateScale:true,//brings chart from inside out
                }
            }

});



