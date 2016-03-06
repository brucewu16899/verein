<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>VisualAppeal Connect</title>

		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic" rel="stylesheet" type="text/css">
		<link href="{{ elixir('css/all.css') }}" rel="stylesheet">

		<meta name="csrf-token" content="{{ csrf_token() }}" />
	</head>

	<body class="skin-black">
		<div class="wrapper">
			@include('layouts._header')

			@include('layouts._sidebar')

			<!-- Content -->
			<div class="content-wrapper">
				@include('flash::message')

				@yield('content')
			</div>
			<!-- /.content-wrapper -->

			@include('layouts._footer')
		</div>

		<script src="{{ elixir('js/vendor.js') }}"></script>
		<script src="{{ elixir('js/app.js') }}"></script>
	</body>
</html>
