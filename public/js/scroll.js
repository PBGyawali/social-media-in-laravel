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
        let url=pagelink + "?page=" + page
        $('.ajax-loader').removeClass('d-none');
        $('.finished').addClass('d-none');
        ajaxCall(url).then(function (data){
            if (data.length == 0) {
                $('.finished').removeClass('d-none');
                    return;
                }
            $(".postwall").append(data);
        }).catch(function(){
            $('.finished').removeClass('d-none');
        }).then(function(){
            $('.ajax-loader').addClass('d-none');
        })
        
    }
});
