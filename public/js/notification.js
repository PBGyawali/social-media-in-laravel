$(document).ready(function()
{
    $('.alertaction,.logaction,.messageaction').on('click', function()
    {
      var action= $(this).data('action');
      var type= $(this).data('type');
      var id= $(this).data('id');
      var url=$('#ajaxurl').val();
      var method_type=$(this).data('method_type');
      $clickedbutton=$(this);
      $div=$clickedbutton.closest('div.row');
      $hidden= $(this);
      var sender_id=$(this).data('sender_id');
      if(action=='delete'){
       $hidden= $div.fadeOut('slow');
      }
      if(action=='delete_similar'){
        $hidden=$('.'+type).fadeOut('slow');
      }
      if(action=='read'){
        $hidden=$div.attr('css','slow');
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
                sender_id:sender_id
            },
            dataType:"JSON",
            error:function(request){
                $hidden.show()
            },
            success: function(data)
            {
                if (data)
                {
                    $.each(data, function(key, value){
                            if(value==0)
                            $('#'+key).text('');
                            else if(value>3)
                            $('#'+key).text(value+'+');
                            else
                            $('#'+key).text(value);
                    });
                        
                }
            }
        });
    });

});



