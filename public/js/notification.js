$(document).ready(function()
{
    $('.alertaction,.logaction').on('click', function()
    {
      var action= $(this).data('action');
      var type= $(this).data('type');
      var id= $(this).data('id');
      var url=$('#ajaxurl').val();
      var method_type=$(this).data('method_type');
      $clickedbutton=$(this);
      $div=$clickedbutton.closest('div.row');
      $hidden= $(this);
      if(action=='delete'){
       $hidden= $div.fadeOut('slow');
      }
      if(action=='delete_similar'){
        $hidden=$('.'+type).fadeOut('slow');
      }
      finalurl=url+method_type;
      //return
      $.ajax
      ({
            url: finalurl,
            method: 'post',
            data:
            {
                action:action,
                type:type,
                id:id,
            },
            dataType:"JSON",
            error:function(request){
                $hidden.show()
            },
            success: function(data)
            {
                if (data!=="")
                {
                    data=data.response
                    if(data==0)
                        $('#alertcount').text('');
                    else if(data>3)
                        $('#alertcount').text(data+'+');
                    else
                        $('#alertcount').text(data);
                }
            }
        });
    });

    $('.messageaction').on('click', function()
    {
      var action= $(this).data('action');
      var id= $(this).data('id');
      var sender_id=$(this).data('sender_id');
      var url=$('#ajaxurl').val();
      $clickedbutton=$(this);
      var method_type=$(this).data('method_type');
      $div=$clickedbutton.closest('div.row');
      if(action=='delete'){
        $div.fadeOut('slow');
      }
      if(action=='read'){
        $div.attr('css','slow');
      }
      finalurl=url+method_type
//alert(finalurl)
      $.ajax
      ({
            url:finalurl,
            method: 'post',
            data:
            {
                action:action,
                id:id,
                sender_id:sender_id
            },
            dataType:"JSON",
            error:function(request)
            {
                $div.show();
            },
            success: function(data)
            {
                if (data!=="")
                {
                    data=data.response
                    if(data==0)
                        $('#messagecount').text('');
                    else if(data>3)
                        $('#messagecount').text(data+'+');
                    else
                        $('#messagecount').text(data);
                }
            }
        });
});






});



