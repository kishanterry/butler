<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>aBit Butler</title>

	<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	{{--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>--}}

	<!-- Custom CSS -->
	@yield('custom_css')

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="{{ asset('js/html5shiv.min.js') }}"></script>
		<script src="{{ asset('js/respond.min.js') }}"></script>
	<![endif]-->
</head>
<body>
	@include('layouts.partials.nav')
	@yield('content')

	<!-- Scripts -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script>
	(function($) {
		$('body').on('hidden.bs.modal', function(e) {
			$(e.target).removeData('bs.modal');
		});
	})(window.jQuery);
	</script>
	@include('layouts.partials.jsvars')

	<!-- Custom JS -->
	@yield('footer_js')
</body>
</html>
