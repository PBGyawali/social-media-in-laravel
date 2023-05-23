@include('config')
@include('minimal_header')
@include('sidebar');
<link rel="stylesheet" href="<?= CSS_URL?>userhome.css">
</head>
<html>
<body >
	<div class="container container-fluid mt-3">
		<div class="row">
			<div class="col-md-12 pl-0">
				<div class=user_info>
					<h2><b>Hi </b><strong style="color: green";><?= $username??''; ?></strong>,
				</div>
				<div class="welcome">
				<h2>Welcome to <?= $website_name??'our website'; ?></b></h2>
				</div>
				<div class="info">
					<Section>
						<p class="mt-7">
							This is a website meant to bring interested readers and creative writers into one platform.
							If you have some creative stories then dont forget to post it to us
							by clicking on the contact us button.To know more about us click on Submit Post button located on the
							left side of this page.
						</p>
					</Section>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
					<Section class=topic>
						<h3 class="content-title"><b>Here you can read following type of stories</b>:</h3>
						<div class="table-div">
								@if ($topics->isEmpty())
									<h1>Till now we do not have any topics in the database.</h1>
								@else
									<div class="col-md-5">
										<table class="table text-warning table-responsive text-left">
											<thead >
												<th class='id'>S.N.</th>
												<th class="name">Topic Name</th>
											</thead>
											<tbody>
												@foreach ($topics as $key => $topic)
                                                    <tr>
                                                        <td><?= $key + 1; ?></td>
                                                        <td>
                                                            <a href="<?= route('topic.show',$topic->id)?>" target="_blank">
                                                            <?= $topic->name; ?></a>
                                                        </td>
                                                    </tr>
												@endforeach
											</tbody>
										</table>
									</div>
								@endif
						</div>
					</section>
					<div class="col-md-7">
					</div >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 pl-0">
				<p style="font-size:8;">We prefer inspiring stories as a video. You will be rewarded as a top user is your video reaches a huge view.</p>
				<p>Here is a demo video for you...</p>
				<div class="imlk" >
					<a data-fancybox href="https://www.youtube.com/watch?v=YRgSvRp676I" data-width="1600" data-height="900" >
					<img class="card-img-top img-fluid" src="https://i.ytimg.com/vi/YRgSvRp676I/maxresdefault.jpg" /></a>
				</div>
			</div>
		</div>
		<div class="row mt-5 px-0">
			<div class="col-12">
			<h2>These are some of the recent articles</h2>
			</div>
		</div>
		<div class="row mt-3">
            @foreach ($posts as $post)
                @isset($post->topic->name)
                    <?php $button=$post->topic->name?>
                @endisset
                @include('postcard')
            @endforeach
        </div>
		<div class="row">
			<div class="col-md-9 w-100">
			    @include('minimal_footer')
			    @include('footer_script')
			</div>
		</div>
	</div>
</body>
</html>

<script src="<?= JS_URL?>jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="<?= CSS_URL?>jquery.fancybox.min.css" />
