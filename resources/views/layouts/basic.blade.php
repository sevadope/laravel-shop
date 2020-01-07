<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Electronics Store</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/basic.css') }}" rel="stylesheet">
</head>
<body>
	@section('first-navbar')
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		</nav>
	@show
	@section('second-navbar')
		<nav class="navbar navbar-expand-lg navbar-white bg-white">
		</nav>
	@show
	<main>
		@yield('left_panel')	

		<div class="main">
			@yield('content')
		</div>
	</main>
</body>
</html>