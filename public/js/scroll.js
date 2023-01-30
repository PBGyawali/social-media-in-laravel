$(document).ready(function(){
var pagelink = $('#scroll_server').val();
var page = 1;
       $(document).on("scroll", function(e){
        if ($(window).scrollTop() == $(document).height() - $(window).height()){
            if($(".post-wrapper").length < $("#total_count").val()) {
                page++;
                if(!pagelink)
                    return
               getMoreData();
			}
			else
                $('.finished').removeClass('d-none');
        }
    });

function getMoreData() {
        $.ajax({
        url: pagelink + "?page=" + page,
        beforeSend: function () {
			$('.ajax-loader').removeClass('d-none');
            $('.finished').addClass('d-none');
        },
        error:function(){
            $('.finished').removeClass('d-none');
        },
        complete: function (){
            $('.ajax-loader').addClass('d-none');
        },
        success: function (data) {
            if (data.length == 0) {
                $('.finished').removeClass('d-none');
                    return;
                }
            $(".postwall").append(data);
        }
   });
}
});
