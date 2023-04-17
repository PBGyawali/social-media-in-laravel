<?= $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
?>
</head>
<body>
    @include('minimal_header');
    @include('sidebar');
    <div class="container container-fluid my-0 mb-8">
                <div class="content text-center">
                    <h2 class="content-title text-primary mt-2"> Recent Articles on <u><?= $topic_name; ?></u></h2>
                    <div class="row mt-3">
                        @if(isset($posts)&& !$posts->isEmpty())
                            @foreach ($posts as $key=>$post)
                                @include('postcard')
                            @endforeach
                        @else
                            <div class="col-12 ">
                                <div class="text-center bg-info alert alert-warning text-white border-0">
                                    <h1 >No Post Found...</h1>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            <div class="content text-center">
                <h2 class="content-title text-primary mt-2 my-0">Trending Articles on <u><?= $topic_name; ?></u></h2>
                <div class="row mt-3">
                    @if (isset($pasts)&& !$pasts->isEmpty())
                            @foreach ($pasts as $key=>$post)
                                @include('postcard')
                            @endforeach
                    @else
                        <div class="col-12 ">
                            <div class="text-center bg-info alert alert-warning text-white border-0">
                                <h1 >No Post Found...</h1>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
    </div>


@include('minimal_footer')
<?php include_once(INCLUDES.'footer.php'); ?>
@include('footer_script')
