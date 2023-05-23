@include('config')
@include('minimal_header')
<link rel="stylesheet" type="text/css" href="<?= CSS_URL?>post.css">
<style type="text/css">
body {
    font-family: Arial;
}
 
</style>
</head>
<body class="pt-0 bg-gray-200 ">
    @include('sidebar')
@include('message')
    <div class="post-wall ">
	<input type="hidden"  id="total_count" value="<?= $count??0; ?>" />
    <input type="hidden"  id="action_server" value="<?= route('article'); ?>" />
    <input type="hidden"  id="scroll_server" value="<?= route('home'); ?>" />
    <input type="hidden" id="rating_server" value="<?= route('ratings')?>" />
    </div>
<div class="container-fluid mt-3">
	<div class="row mx-0">
		<div class="col-xs-0 col-md-2 mx-0 px-0">
		</div>
		<div class="col-xs-12 col-md-6 offset-md-1 px-0 postwall bg-gray-100 whitespace-normal break-all border-solid border-2 border-t-0 border-b-0 border-yellow-800 rounded-lg" >
            @include('moredata')
		</div>
		    @include('minimal_footer')
			<div class=" col-md-2 mx-0 px-0 d-none d-sm-block">
                @if ($check)
                    @include('chatbox')
                @endif
            </div>
    </div>
    <div class="row mb-2">
		<div class="col-xs-0 col-md-2 mx-0 px-0">
        </div>
        <div class="col-xs-12 col-md-6 offset-md-1 ">
            <div class="ajax-loader d-none text-center mb-2">
                <i class="fa fa-spinner fa-pulse fa-3x text-secondary"></i>
                <h4 class="d-inline"> Loading more posts...</h4>
            </div>
            <div class="finished d-none text-center mb-2">
                <h4>No more posts available...</h4>
            </div>
        </div>
    </div>
</div><!-- container div end -->

<div class="container-fluid mb-0 d-none d-md-block position-fixed bottom-0" style="z-index:10;">
	<div class="row py-0 px-1">
		<div class="col-10 pl-0 pr-0">
			<div class="d-flex flex-column" >
                <nav class="navbar navbar-expand-sm navbar-light bg-transparent chatbox-content">                         
                    
                </nav>                      
	        </div>
	    </div>
	</div>
</div>
@include('footer')
<script type="text/javascript" src="<?= JS_URL?>scroll.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>comment_system.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>user_action.js" ></script>
@include('footer_script')

<script>  
    function update(data,response){
        $(`#user-chat-content${response.id}`).append(response.update)
        if ("conversation_id" in response && response.conversation_id){
            $(`#conversation_id${response.id}`).val(response.conversation_id);
        }
    }
    </script>