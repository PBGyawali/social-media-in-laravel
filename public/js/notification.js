  $(document).on('click','.alertaction,.logaction,.messageaction',function()
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
      var sendData={action:action,type:type,id:id, sender_id:sender_id}
        ajaxCall(finalurl,sendData).then(function(data)
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
        }).catch(function(){
            $hidden.show()
        })
    });




