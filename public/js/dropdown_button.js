
$(document).ready(function(){
  $('.dropdown-btn').each(function ()	{
          var dropdown= $(this);
          dropdown.on("click", function()  {
                $(this).toggleClass("active_class");
                var dropdownContent = $(this).siblings();
                $(dropdownContent).toggle();
            });
		});

});

