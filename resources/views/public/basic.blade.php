@extends('layouts.basic')

@section('first-navbar')
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  	<a class="navbar-brand" href="{{ route('categories.index') }}">
	  		Electronics Store
	  	</a>
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	   		<span class="navbar-toggler-icon"></span>
	  	</button>

	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	   		<ul class="navbar-nav mr-auto">

	   			@auth   
	   				<li class="nav-item active">
	   					<a href="{{ route('users.cart.show') }}" class="nav-link">
	   						My Cart
	   					</a>
	   				</li>				
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

		      		<li class="nav-item active">
		        		<a class="nav-link" href="{{ route('login') }}">
		        			Cart
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
@endsection

@section('second-navbar')
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			@yield('breadcrumb')
		</ol>
	</nav>
@endsection

@section('left_panel')
	<div class="filter-box-wrapper">
		@yield('filter-box')	
	</div>	
@endsection

