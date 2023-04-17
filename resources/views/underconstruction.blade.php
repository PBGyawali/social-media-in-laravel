@include('config')
@include('minimal_header')

<title>Under construction</title>
<style>
body, html {
  height: 100%;
}
body {
  background-image: url('<?=BACKGROUNDS_URL?>simple.jpg');
  background-repeat: no-repeat;
  background-size: 100% 100%;
  }
</style>

</head>
<body>
<div class="container container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="text-center text-warning">
		  		<h1>COMING SOON</h1>
		  		<p id="time_remaining" style="font-size:30px">Enable your javascript to fully view the remaining days</p>
			</div>
			<div class=" fixed-bottom text-warning text-left ml-5 mb-1" >
		  		<p >Thank you for your Understanding</p>
			</div>
		</div>

	</div>
</div>



	  </div>
	  <script src="<?= JS_URL?>comingsoon.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
