$(document).ready(function() {
    emailcondition=usernamecondition=true
    $('.user_form').parsley();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

	window.onhashchange = function() {
		var hash = window.location.hash;
		check(hash);
   }

   function check(hash){
    var array=['#login','#register','#reset_password','#homepage','#conditions','#about','#main','#contact'];
            if (hash !=null && hash!='' && jQuery.inArray(hash,array)!= -1){
                    show(hash);
            }
    }

   function show(data,event=null){
	if(event){ event.preventDefault();}
    $('.container, .content').hide()
    if($(data+'_container').length){
        $(data+'_container').show()
        $('.main-nav ul li a').removeClass('active'); //remove active
        $('a[href="'+data+'"]').addClass('active'); // add active
        window.location.hash=data;
    }
}

$('.login_link').on('click', function(event){
    show('#login',event);
    });

    $('.register_link').on('click',function(event) {
    show('#register',event);
    });

    $('.reset_password_link').on('click',function(event) {
    show('#reset_password',event);
    });
    $('.conditions_link').on('click',function(event) {
    show('#conditions',event);
    });
    $('.homepage_link').on('click',function(event) {
    show('#homepage',event);
    });
    /* Main Navigation Clicks */
    $('.main-nav ul li a').click(function() {
            var link = $(this).attr('href');
            show(link);
    });

    $('.user_form').on("submit",function(){
        if($(this).parsley().isValid())
                {
                $button=$(this).find("button") ;
                $button.text('Please Wait').css({"filter": "grayscale(100%)","-webkit-filter":"grayscale(100%)"});
                }

        });

	$('#register_password_1').keyup(function() {
        var password=$(this).val();
        var strength=checkStrength(password);
        $('#strength_message').html(strength);
      })

      function checkStrength(password) {
          var strength = 0
          if (password.length < 1) {
            $('#strength_message').removeClass();
            return false;
        }
          if (password.length < 8) {
              $('#strength_message').removeClass().addClass('text-danger');
              return 'Short';
          }
          if (password.length > 7) strength += 1
          if (password.match(password.match(/([0-9])/))) strength += 1
          // If password contains both lower and uppercase characters, increase strength value.
          if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
          // If it has numbers and characters, increase strength value.
          if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
          // If it has one special character, increase strength value.
          if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
          // If it has two special characters, increase strength value.
          if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
          if (password.length > 12) strength += 1

          if (strength < 2) {
            $('#strength_message').removeClass().addClass('text-warning');
              return 'Weak';
          } else if (strength ==2 || strength==3) {
            $('#strength_message').removeClass().addClass('text-primary');
              return 'Good'
          }
          else if (strength > 3 && strength<6) {
            $('#strength_message').removeClass().addClass('text-info');
              return 'Strong'
          }
          else {
             $('#strength_message').removeClass().addClass('text-success');
              return 'Very Strong'
          }

      }




      $("#login_guest").click(function() {
          $("#login_username").removeAttr("required");
          $("#login_password").removeAttr("required");
      });



      $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $(this).siblings("input");
        var type=input.attr("type");
        if (type == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
        });


        $('.datacheck').on('change', function(){
           $input=$(this);
           var object=$input.data('object');
           var send=object.toLowerCase();
           var value=formcheck($input,send);
          if($input.parsley().isValid())
              {
            ajaxcall(value,send,$input,object)
        }
        });

        $('input').on('blur', function(){
          clear($(this));
          formcheck($(this));
        });
        function formcheck(thisObj,send=null)
        {
            var value=thisObj.val();
            if (value == '')
            {
                thisObj.parsley().reset();
                clear(thisObj);
                if(send)
                    window[send+'condition'] = false;
            }
              return value;
        }

        function clear(thisObj,css=null,span=null){
          thisObj.siblings("span").html('');
          thisObj.parent().removeClass("form_success form_error");
          if(css) {thisObj.parent().addClass(css); }
          if (span){thisObj.siblings("span:not('.text-danger')").html(span); }
        }

        function ajaxcall(value,send,$input,object){
            url=$('#register_form').data('url')+'/check';
          $.ajax({
             url:url,
             method: 'POST',
             dataType:"JSON",
             data: {'check' : 1,'data' : value, 'column':send},
             success: function(response){
               if (response == 'exists' ) {
                clear($input,'form_error', object+" "+response+" "+ "<i class='fas fa-times checkdata'></i>");
                window[send+'condition'] = false;
               }else if (response == 'available') {
                clear($input,'form_success',object+" "+response+" "+ "<i class='fas fa-check-circle checkdata'></i>");
                window[send+'condition'] = true;

               }
             }
          });
        }

        $('#reg_btn').on('click', function(event){
          if ( emailcondition==false || usernamecondition==false) {
           $('#error_msg').html('<div class="bg-danger alert text-white">We cannot move forward until the all the errors on the form is resolved</div>').fadeTo(3500, 800).slideUp(800);
           event.preventDefault();
         }else{
             // proceed with form submission
             $('#register_form').submit();
          }
        })
});
