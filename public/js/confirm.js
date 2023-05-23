
  $(document).on('change','.file_upload',function(event)
  {
          var fileInput = $(this);
          var extension = fileInput.val().split('.').pop().toLowerCase();
          var upload_time=fileInput.data('upload_time');
          var file = fileInput[0].files[0];
          var filesize = file.size;
          const allowed_file=fileInput.data('allowed_file');
          const allowed_image=fileInput.data('allowed_image');
          let accept_type=fileInput.attr('accept').replaceAll('.','')
          .replaceAll('image/','').split(',');
          if(extension)
          {
                if(allowed_file && !allowed_file.includes(extension)){
                    return fileAlert("Not an accepted File type");
                }
                else if(!allowed_file && accept_type && !accept_type.includes(extension)){
                    return fileAlert(`${extension} file are not accepted`);
                }
                else if(allowed_image && jQuery.inArray(extension, allowed_image) == -1)
                {
                  return fileAlert("Invalid Image File type");
                }
                else if (filesize > 50000000)
                {
                  return fileAlert("File Image size is too large");
                }
                else if(allowed_image ||accept_type.includes(extension))
                {
                        var _URL = window.URL || window.webkitURL;
                        var image = new Image();
                        image.src = _URL.createObjectURL(file);
                        image.onload = function()
                        {
                            imgwidth = this.width;
                            imgheight = this.height;
                            if (imgheight + imgwidth == 0)
                                return fileAlert('This file is not an image');
                            else if (upload_time=='now')
                                uploadNow();
                            else{
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    if(!$('.settings').length)
                                    $('#profile_image,.profile_image').attr('src', e.target.result);
                                };
                                reader.readAsDataURL(file);
                            };
                        }
                        image.onerror = function() {
                           return fileAlert(`This is not a valid ${extension} file`);
                         }                        
                };
          }
  });

  $(document).on('click','.delete_btn',function(event){
      event.preventDefault();
      var sendUrl = $('#picture_upload').attr('action');
      data={"delete_picture":1} ;
      confirmAction(sendUrl,data,"delete the image permanently",'POST','Delete Picture!','red')
      .then(result=>{
        $('#upload_icon_text').text('Upload New');
        $('.delete_btn').remove();
      })
    });

    function uploadNow()
    {
      var sendUrl = $('#picture_upload').attr('action');
      var form = $('form#picture_upload')[0]; // You need to use standard javascript object here
      var data  = new FormData(form);
      confirmAction(sendUrl,data,"change the image",'POST','Change Image!').then(result=>{
        $('#upload_icon_text').text('Change');
      })
    }

    function fileAlert($content){
      showAlert($content,'File selection Invalid')
    }

    $("a.logout,button.logout").click(function(event)
    {
        event.preventDefault();
        var logOutUrl=$(this).attr('href');
        var form = $(this).closest('form');
        $.confirm
        ({
            title: 'Log Out!',
            content: 'This will log you out. Are you sure buddy?',
            buttons:{
                Yes:{//name of the function
                    action: function(){
                      form.submit();
                      if(logOutUrl!='' && typeof logOutUrl!='undefined')
                      window.location.href =  logOutUrl;
                    }
                },
            }
         });
    });

  $("a#logout,button.logout").hover(function()
  {
    $(this).css({"background-color": "red","color":"white"});
  },
    function(){//return to original state when hover out
      $(this).css({"background-color": "","color":""});
  });



















