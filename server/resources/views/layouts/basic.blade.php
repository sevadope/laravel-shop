<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Electronics Store</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/basic.css') }}" rel="stylesheet">

</head>
<body>
	<div id="app">
		<nav class="navbar navbar-dark bg-dark">
			<a class="navbar-brand" href="#">Admin panel</a>
		</nav>
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
</body>
</html>