<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Electronics Store</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/basic.css') }}" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  		<a class="navbar-brand" href="#">
  			Electronics Store
  		</a>
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
  		</button>

  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
    			@auth
    			@else
	      			<li class="nav-item active">
	        			<a class="nav-link" href="{{ route('login') }}">
	        				Login
	        				<span class="sr-only">(current)</span>
	        			</a>
	      			</li>

	      			<li class="nav-item active">
	        			<a class="nav-link" href="{{ route('register') }}">
	        				Sign Up
	        				<span class="sr-only">(current)</span>
	        			</a>
	      			</li>
    			@endauth
   			</ul>
    		<form class="form-inline my-2 my-lg-0">
      			<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">
      				Search
      			</button>
    		</form>
  		</div>
	</nav>
	<main>
		<div class="filter-box-wrapper">
			<ul class="nav flex-column filter-box-list">
				<span class="filter-box-title">Cell Phones</span>
			 	<li class="nav-item">
			    	<a class="nav-link active" href="#">Active</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link" href="#">Link</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link" href="#">Link</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
			    		Disabled
			    	</a>
			  </li>
			</ul>

			<ul class="nav flex-column filter-box-list">
				<span class="filter-box-title">Tablets</span>
			 	<li class="nav-item">
			    	<a class="nav-link active" href="#">Active</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link" href="#">Link</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link" href="#">Link</a>
			  	</li>
			  	<li class="nav-item">
			    	<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
			    		Disabled
			    	</a>
			  </li>
			</ul>			
		</div>		

		<div class="main">
			@yield('content')
		</div>
	</main>
</body>
</html>